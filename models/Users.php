<?php

namespace app\models;

use Yii;

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
            [['iduser', 'username', 'password', 'role', 'userkey', 'email', 'status', 'phone'], 'required'],
            [['role', 'status'], 'integer'],
            [['lastlogin'], 'safe'],
            [['iduser', 'name', 'userkey'], 'string', 'max' => 30],
            [['username', 'phone'], 'string', 'max' => 20],
            [['password', 'lastname', 'email'], 'string', 'max' => 50],
            [['userkey'], 'unique'],
            [['email'], 'unique'],
            [['iduser'], 'unique'],
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
}
