<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trs_rentdet".
 *
 * @property string $idtrsrentdet
 * @property string $idtrsrent
 * @property int $paid
 * @property string|null $note
 *
 * @property TrsRent $idtrsrent0
 */
class TrsRentdet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trs_rentdet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtrsrentdet', 'idtrsrent', 'paid'], 'required'],
            [['paid'], 'integer'],
            [['note'], 'string'],
            [['idtrsrentdet', 'idtrsrent'], 'string', 'max' => 64],
            [['idtrsrentdet'], 'unique'],
            [['idtrsrent'], 'exist', 'skipOnError' => true, 'targetClass' => TrsRent::class, 'targetAttribute' => ['idtrsrent' => 'idtrsrent']],
            ['paid', 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['paiddate'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtrsrentdet' => 'Idtrsrentdet',
            'idtrsrent' => 'Idtrsrent',
            'paid' => 'Bayar',
            'note' => 'Catatan',
            'paiddate' => 'Tanggal Bayar', 
        ];
    }

    /**
     * Gets query for [[Idtrsrent0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdtrsrent0()
    {
        return $this->hasOne(TrsRent::class, ['idtrsrent' => 'idtrsrent']);
    }
}
