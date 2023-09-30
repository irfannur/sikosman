<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trs_map".
 *
 * @property string $idmap
 * @property string $idfrom
 * @property string $idto
 * @property int|null $type
 * @property string $note
 */
class TrsMap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trs_map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idmap', 'idfrom', 'idto'], 'required'],
            [['type'], 'integer'],
            [['idmap', 'idfrom'], 'string', 'max' => 30],
            [['idto'], 'string', 'max' => 60],
            [['note'], 'string', 'max' => 100],
            [['idmap'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idmap' => 'Idmap',
            'idfrom' => 'Idfrom',
            'idto' => 'Idto',
            'type' => 'Type',
            'note' => 'Note',
        ];
    }
}
