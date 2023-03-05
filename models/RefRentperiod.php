<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_rentperiod".
 *
 * @property string $idrentperiod
 * @property string $rentperiodname
 * @property string|null $rentperiodalias
 * @property int|null $price
 * @property string|null $lastupdated
 * @property int|null $ordering
 * @property int $day
 */
class RefRentperiod extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ref_rentperiod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['idrentperiod', 'rentperiodname', 'day'], 'required'],
            [['price', 'ordering', 'day'], 'integer'],
            [['lastupdated'], 'safe'],
            [['idrentperiod'], 'string', 'max' => 64],
            [['rentperiodname', 'rentperiodalias'], 'string', 'max' => 34],
            [['idrentperiod'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idrentperiod' => 'Idrentperiod',
            'rentperiodname' => 'Tipe Sewa',
            'rentperiodalias' => 'Alias',
            'price' => 'Harga',
            'lastupdated' => 'Lastupdated',
            'ordering' => 'Ordering',
            'day' => 'Hitungan (Hari)',
        ];
    }

    public static function getListPeriod($arrmap = true) {
        $period = RefRentperiod::find()->orderBy('ordering')->all();
        $map = ArrayHelper::map($period, 'idrentperiod', 'rentperiodname');
        return $arrmap ? $map : $period;
    }

}
