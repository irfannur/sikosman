<?php

//return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=kosman',
//    'username' => 'root',
//    'password' => '',
//    'charset' => 'utf8',
//];

//prod
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=192.168.0.100;dbname=sikosman_2023',
    'username' => 'sikosman_2023',
    'password' => 'sikosman_2023',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
