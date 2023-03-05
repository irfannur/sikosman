<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_tenant".
 *
 * @property string $idtenant
 * @property string|null $nik
 * @property string $name
 * @property string|null $address
 * @property string|null $dob
 * @property string $startin
 * @property string|null $endin
 * @property string|null $note
 * @property string|null $status
 * @property string|null $lastpayment
 *
 * @property TrsRent[] $trsRents
 */
class MstTenant extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mst_tenant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['idtenant', 'name', 'startin'], 'required'],
            [['dob', 'startin', 'endin', 'lastpayment'], 'safe'],
            [['note'], 'string'],
            [['idtenant', 'name', 'idbuilding', 'university'], 'string', 'max' => 64],
            [['nik'], 'string', 'max' => 34],
            [['address'], 'string', 'max' => 225],
            [['status'], 'string', 'max' => 11],
            [['idtenant'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idtenant' => 'Idtenant',
            'nik' => 'NIK',
            'name' => 'Nama',
            'address' => 'Alamat',
            'dob' => 'Tanggal Lahir',
            'startin' => 'Tanggal Masuk',
            'endin' => 'Tanggal Keluar',
            'note' => 'Catatan',
            'status' => 'Status',
            'lastpayment' => 'Pembayaran Terakhir',
            'idbuilding' => 'idbuilding',
            'university' => 'Universitas'
        ];
    }

    /**
     * Gets query for [[TrsRents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrsRents() {
        return $this->hasMany(TrsRent::class, ['idtenant' => 'idtenant']);
    }

    public function getIdbuilding0() {
        return $this->hasOne(MstBuilding::class, ['idbuilding' => 'idbuilding']);
    }

    const STAT_NEW = 'NEW';
    const STAT_ACTIVE = 'ACTIVE';
    const STAT_INACTIVE = 'INACTIVE';

    public static function getListStatus() {
        return [
            self::STAT_NEW => 'BARU',
            self::STAT_ACTIVE => 'AKTIF',
            self::STAT_INACTIVE => 'TIDAK AKTIF'
        ];
    }

    public static function getListTenant($idbuilding = null, $isready = true, $arrmap = true) {
        $stat = $isready ? self::STAT_NEW : null;
        $qroom = MstTenant::find()
                ->select([new \yii\db\Expression('CONCAT(mst_tenant.name, " (", coalesce(mst_tenant.university, mst_tenant.NIK, ""),") - ", mst_building.buildingname) as fname'), 'mst_tenant.*'])
                ->joinWith(['idbuilding0'])
                ->andFilterWhere(['mst_tenant.status' => $stat])
                ->andFilterWhere(['mst_tenant.idbuilding' => $idbuilding])
                ->asArray()
                ->all();
        
        $map = \yii\helpers\ArrayHelper::map($qroom, 'idtenant', 'fname');
        return $arrmap ? $map : $qroom;
    }

}
