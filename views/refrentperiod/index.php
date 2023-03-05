<?php

use app\models\RefRentperiod;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ref Rentperiods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-rentperiod-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ref Rentperiod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idrentperiod',
            'rentperiodname',
            'rentperiodalias',
            'price',
            'lastupdated',
            //'ordering',
            //'day',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RefRentperiod $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idrentperiod' => $model->idrentperiod]);
                 }
            ],
        ],
    ]); ?>


</div>
