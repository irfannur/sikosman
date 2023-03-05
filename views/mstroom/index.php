<?php

use app\models\MstRoom;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var View $this */
/** @var ActiveDataProvider $dataProvider */
$this->title = 'Kamar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mst-room-index">

    <p class="float-right">
    <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'roomname',
        'roomnumber',
        'idbuilding0.buildingname',
        //'height',
        //'weight',
        'status',
        //'lastrepair',
        //'note:ntext',
        'price',
        [
            'class' => kartik\grid\ActionColumn::className(),
            'urlCreator' => function ($action, MstRoom $model, $key, $index, $column) {
                return Url::toRoute([$action, 'idroom' => $model->idroom]);
            }
        ],
    ];
    echo GridView::widget(Yii::$app->params['gridConfig'] + [
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumns, // check this value by clicking GRID COLUMNS SETUP button at top of the page
       
    ]);
    ?>


</div>
