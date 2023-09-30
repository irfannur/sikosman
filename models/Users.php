<?php

namespace app\models;

use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 *
 * @property string $iduser
 * @property string $username
 * @property string $password
 * @property string|null $name
 * @property int $role
 * @property string|null $lastlogin
 * @property string $userkey
 * @property string|null $lastname
 * @property string $email
 * @property int $status
 * @property string $phone
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser', 'username', 'password', 'role', 'idbuildings'], 'required'],
            [['role', 'status'], 'integer'],
            [['lastlogin'], 'safe'],
            [['iduser', 'name', 'userkey'], 'string', 'max' => 30],
            [['username', 'phone'], 'string', 'max' => 20],
            [['password', 'lastname', 'email'], 'string', 'max' => 50],
            [['userkey', 'username'], 'unique'],
            [['email'], 'unique'],
            [['iduser'], 'unique'],
            [['idbuildings'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iduser' => 'Iduser',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'role' => 'Role',
            'lastlogin' => 'Lastlogin',
            'userkey' => 'Userkey',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'status' => 'Status',
            'phone' => 'Phone',
        ];
    }

    public $idbuildings;

    public static function getUserBuilding($iduser, $ismap = false, $isdp = false) {
        $m = (new Query())->select(['b.*'])
            ->from(['m' => TrsMap::tableName()])
            ->innerJoin(['b' => MstBuilding::tableName()], "m.idto = b.idbuilding")
            ->where(['idfrom' => $iduser])
            ->all();

        if ($ismap) {
            return ArrayHelper::map($m, 'idbuilding', 'buildingname');
        } else if ($isdp) {
            $dataProvider = new ArrayDataProvider([
                'allModels' => $m,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            return $dataProvider;
        }
        return ArrayHelper::getColumn($m, 'idbuilding');
    }

    public static function saveBuildings($idbuilds, $iduser, &$msg = null) {
        foreach ($idbuilds as $perBuild) {
            $mmap = new TrsMap();
            $mmap->idmap = uniqid();
            $mmap->idfrom = $iduser;
            $mmap->idto = $perBuild;
            $mmap->type = 1;
            if (!$mmap->save()) {
                $msg = json_encode($mmap->getErrors());
                break;
            }
        }
    }
}
