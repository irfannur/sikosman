<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_building".
 *
 * @property string $idbuilding
 * @property string $buildingname
 * @property string|null $address
 * @property string|null $since
 *
 * @property MstRoom[] $mstRooms
 */
class MstBuilding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mst_building';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idbuilding', 'buildingname'], 'required'],
            [['since'], 'safe'],
            [['idbuilding', 'buildingname'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 225],
            [['idbuilding'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idbuilding' => 'Idbuilding',
            'buildingname' => 'Bangunan',
            'address' => 'Alamat',
            'since' => 'Dibangun tahun',
        ];
    }

    /**
     * Gets query for [[MstRooms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMstRooms()
    {
        return $this->hasMany(MstRoom::class, ['idbuilding' => 'idbuilding']);
    }
    
    public static function getListBuilding() {
        $data = MstBuilding::find()->all();
        return \yii\helpers\ArrayHelper::map($data, 'idbuilding', 'buildingname');
    }
}
