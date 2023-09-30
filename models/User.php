<?php

namespace app\models;

class User extends Users implements \yii\web\IdentityInterface {

    public $authKey;
    public $accessToken;

    /**
     * @return \app\models\User
     */
    public static function me() {
        return \Yii::$app->user->identity;
    }

    public function fields() {
        $fields = parent::fields();
        unset($fields['password']);
        return array_merge($fields, ['accessToken', 'authKey']);
    }

    public static function generateToken($id) {
        $token = [
            "iss" => "http://qyaraofficial.com",
            "aud" => "qyara.v1",
            "uid" => $id,
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + (1000 * 60 * 60 * 24 * 7)
        ];

        return JWT::encode($token, Yii::$app->params['secret']);
    }

    public static function validateToken($token) {
        try {
            $payload = JWT::decode($token, Yii::$app->params['secret'], ['HS256']);
            return User::findIdentity($payload->uid);
        } catch (Exception $ex) {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $u = User::findOne(['username' => $username]);
        $e = User::find()->where(['UPPER(email)' => strtoupper($username)])->one();
        if ($u)
            return $u;
        if ($e)
            return $e;
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->iduser;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === md5($password);
    }

}
