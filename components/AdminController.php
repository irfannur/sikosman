<?php

namespace app\components;

use app\helpers\Rolename;
use yii\filters\AccessControl;
use app\components\AccessRule;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AdminController extends Controller {

    //public $layout = "main";

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'controllers' => ['report', 'sysusers'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        //'controllers' => ['admins/products', 'admins/users', 'admins/configweb',],
                        'allow' => true,
                        'roles' => [Rolename::SUPER_ADMIN],
                    ],
                    [
                        'controllers' => ['apps/checkout', 'apps/customer'],
                        'allow' => true,
                        'roles' => [Rolename::OPERATOR],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

}
