<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_room".
 *
 * @property string $idroom
 * @property string|null $roomname
 * @property int $roomnumber
 * @property string $idbuilding
 * @property int|null $height
 * @property int|null $weight
 * @property string|null $status
 * @property string|null $lastrepair
 * @property string|null $note
 * @property int $price
 *
 * @property MstBuilding $idbuilding0
 * @property TrsRent[] $trsRents
 */
class MstRoom extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mst_room';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['idroom', 'roomnumber', 'idbuilding', 'price'], 'required'],
            [['roomnumber', 'height', 'weight', 'price'], 'integer'],
            [['lastrepair'], 'safe'],
            [['note'], 'string'],
            [['idroom', 'roomname', 'idbuilding'], 'string', 'max' => 64],
            [['status'], 'string', 'max' => 11],
            [['idroom'], 'unique'],
            [['idbuilding'], 'exist', 'skipOnError' => true, 'targetClass' => MstBuilding::class, 'targetAttribute' => ['idbuilding' => 'idbuilding']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idroom' => 'Idroom',
            'roomname' => 'Nama',
            'roomnumber' => 'Nomor',
            'idbuilding' => 'Bangunan',
            'height' => 'Tinggi',
            'weight' => 'Lebar',
            'status' => 'Status',
            'lastrepair' => 'Renov Terakhir',
            'note' => 'Catatan',
            'price' => 'Harga',
        ];
    }

    /**
     * Gets query for [[Idbuilding0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdbuilding0() {
        return $this->hasOne(MstBuilding::class, ['idbuilding' => 'idbuilding']);
    }

    /**
     * Gets query for [[TrsRents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrsRents() {
        return $this->hasMany(TrsRent::class, ['idroom' => 'idroom']);
    }

    const STAT_READY = 'READY';
    const STAT_RENTED = 'RENTED';
    const STAT_RENOV = 'RENOV';

    public static function getListStatus() {
        return [
            self::STAT_READY => 'BELUM TERSEWA',
            self::STAT_RENTED => 'TERSEWA',
            self::STAT_RENOV => 'SEDANG RENOFASI',
        ];
    }

    public static function getListRoom($idbuilding = null, $isready = true, $arrmap = true) {
        $stat = $isready ? self::STAT_READY : null;
        $qroom = MstRoom::find()
                ->select([new \yii\db\Expression('CONCAT(mst_room.roomname, " (", mst_room.roomnumber,") - ", mst_building.buildingname) as fname'), 'mst_room.*'])
                ->joinWith(['idbuilding0'])
                ->andFilterWhere(['mst_room.status' => $stat])
                ->andFilterWhere(['mst_room.idbuilding' => $idbuilding])
                ->asArray()
                ->all();
        
        $map = \yii\helpers\ArrayHelper::map($qroom, 'idroom', 'fname');
        return $arrmap ? $map : $qroom;
    }

}
