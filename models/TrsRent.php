<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "trs_rent".
 *
 * @property string $idtrsrent
 * @property string $idroom
 * @property string $idtenant
 * @property int $agreeprice
 * @property string $rentdate
 * @property int|null $debt
 * @property string|null $note
 * @property int $day
 * @property int $dayplan
 * @property int $daytotal
 * @property int $pricetotal
 * @property string $rentperiodname
 * @property string $startrent
 * @property string $endrent
 *
 * @property MstRoom $idroom0
 * @property MstTenant $idtenant0
 * @property TrsRentdet[] $trsRentdets
 */
class TrsRent extends \yii\db\ActiveRecord {

    var $idrentperiod;
    var $injurydate;
    var $pretotal;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'trs_rent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['idbuilding', 'idtrsrent', 'idroom', 'idtenant', 'agreeprice', 'rentdate', 'day', 'dayplan', 'daytotal', 'pricetotal', 'rentperiodname', 'startrent'], 'required'],
            [['agreeprice', 'debt', 'day', 'dayplan', 'daytotal', 'pricetotal'], 'integer'],
            [['rentdate', 'startrent', 'endrent', 'idrentperiod', 'injurydate', 'pretotal', 'status'], 'safe'],
            [['note'], 'string'],
            [['idtrsrent', 'idroom', 'idtenant', 'idbuilding'], 'string', 'max' => 64],
            [['rentperiodname'], 'string', 'max' => 34],
            [['idtrsrent'], 'unique'],
            [['idroom'], 'exist', 'skipOnError' => true, 'targetClass' => MstRoom::class, 'targetAttribute' => ['idroom' => 'idroom']],
            [['idtenant'], 'exist', 'skipOnError' => true, 'targetClass' => MstTenant::class, 'targetAttribute' => ['idtenant' => 'idtenant']],
            ['agreeprice', 'compare', 'compareValue' => 0, 'operator' => '>'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idtrsrent' => 'Idtrsrent',
            'idroom' => 'Kamar',
            'idtenant' => 'Anak Kos',
            'agreeprice' => 'Harga Yang Disepakati',
            'rentdate' => 'Tanggal Sewa',
            'debt' => 'Kurang Bayar',
            'note' => 'Catatan',
            'day' => 'Day',
            'dayplan' => 'Berapa Kali Sewa',
            'daytotal' => 'Daytotal',
            'pricetotal' => 'Total Yang Harus dibayar',
            'rentperiodname' => 'Jenis Sewa',
            'startrent' => 'Tanggal Mulai Sewa',
            'endrent' => 'Tanggal Akhir Sewa',
            'idbuilding' => 'Bangunan Kos',
            'idrentperiod' => 'Tipe Sewa',
            'injurydate' => 'Batas Bayar',
            'pretotal' => 'Total Yang Harus dibayar',
            'status' => 'status',
        ];
    }

    /**
     * Gets query for [[Idroom0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdroom0() {
        return $this->hasOne(MstRoom::class, ['idroom' => 'idroom']);
    }

    /**
     * Gets query for [[Idtenant0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdtenant0() {
        return $this->hasOne(MstTenant::class, ['idtenant' => 'idtenant']);
    }

    /**
     * Gets query for [[TrsRentdets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrsRentdets() {
        return $this->hasMany(TrsRentdet::class, ['idtrsrent' => 'idtrsrent']);
    }

    public static function getListDayplan() {
        return [
            1 => '1 x',
            2 => '2 x',
            3 => '3 x',
            4 => '4 x',
            5 => '5 x',
        ];
    }

    public static function bagdeStatus($status) {
        $b = [
            'LEBIH' => '<span class="badge badge-primary">' . $status . '</span>',
            'LUNAS' => '<span class="badge badge-success">' . $status . '</span>',
            'BELUM LUNAS' => '<span class="badge badge-danger">' . $status . '</span>',
        ];

        return isset($b[$status]) ? $b[$status] : '-';
    }

    public static function bagdeProsen($prosen) {
        if ($prosen >= 100) {
            $res = '<span class="badge badge-success">' . $prosen . ' %</span>';
        } elseif ($prosen >= 80) {
            $res = '<span class="badge badge-warning">' . $prosen . ' %</span>';
        } else {
            $res = '<span class="badge badge-danger">' . $prosen . ' %</span>';
        }
        return $res;
    }

    public static function getStatus($pricetotal, $paid) {
        $stat = null;
        if ($paid < $pricetotal) {
            $stat = 'BELUM LUNAS';
        } elseif ($paid === $pricetotal) {
            $stat = 'LUNAS';
        } elseif ($paid > $pricetotal) {
            $stat = 'LEBIH';
        }

        return $stat;
    }

    public static function getDebt($pricetotal, $curpaid) {
        return (float) $pricetotal - (float) $curpaid;
    }

    public static function getPricetotal($agreeprice, $dayplan) {
        return ((float) $agreeprice * (float) $dayplan);
    }

    public static function getTrsrentdet($idtrsrent, $sqlOnly = false) {
        $r = TrsRentdet::find()->where(['idtrsrent' => $idtrsrent])->orderBy(['paiddate' => SORT_DESC]);
        if (!$sqlOnly) {
            return $r->asArray()->all();
        }
        return $r;
    }

    public function resume() {
        $max = (new Query())
                ->select(['t.idroom', new Expression("max(t.rentdate) maxdate")])
                ->from(['t' => TrsRent::tableName()])
                ->where(['<>', 't.status', 'KELUAR']);
        $rent = (new Query())
                ->select(['tt.*'])
                ->from(['t' => $max])
                ->innerJoin(['tt' => TrsRent::tableName()], "t.maxdate = tt.rentdate and t.idroom = tt.idroom");

        $rentdet = (new Query())
                ->select(['tr.idtrsrent', new Expression("sum(tr.paid) as paid")])
                ->from(['tr' => TrsRentdet::tableName()])
                ->groupBy(['tr.idtrsrent']);

        $sql = (new Query())->select([
                    't.idtrsrent',
                    't.idbuilding',
                    new Expression("concat(mr.roomname, ' #', mr.roomnumber) roomname"),
                    'mt.name',
                    "mt.nik",
                    new Expression("concat(t.dayplan, ' ', t.rentperiodname) lama"),
                    "t.agreeprice",
                    "t.pricetotal",
                    "t.startrent",
                    "dt.paid",
                    new Expression("case when coalesce(dt.paid, 0) <> 0 then round((dt.paid/t.pricetotal) * 100, 2) else 0 end prosen"),
                ])
                ->from(['t' => $rent])
                ->leftJoin(['dt' => $rentdet], "t.idtrsrent = t.idtrsrent")
                ->leftJoin(['mt' => MstTenant::tableName()], "t.idtenant = mt.idtenant")
                ->leftJoin(['mr' => MstRoom::tableName()], "t.idroom = mr.idroom")
                ->all();
        
        return $sql;
    }

}
