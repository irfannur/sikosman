<?php

namespace app\helpers;

use Yii;

class Utils {

    public static function flash($type, $msg) {
        return Yii::$app->session->setFlash($type, $msg);
    }

    public static function idrPrice($price) {
        $price = Yii::$app->formatter->asCurrency($price);
        $price = substr($price, 0, -3);
        return $price;
    }

}
