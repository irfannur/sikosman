<?php

use app\helpers\Utils;
use app\models\TrsRent;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Sewa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trs-rent-index">

    <p class="float-right">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    <h3><?= Html::encode($this->title) ?></h3>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'roomname',
            'name',
            [
                'attribute' => 'startrent',
                'header' => 'Tanggal',
                'value' => function ($model) {
                    return date('Y-m-d', strtotime($model['startrent']));
                }
            ],
            'lama:ntext:Periode Sewa',
            [
                'attribute' => 'pricetotal',
                'header' => 'Total Harus Bayar',
                'value' => function ($model) {
                    return Utils::idrPrice($model['pricetotal']);
                }
            ],
            [
                'attribute' => 'paid',
                'header' => 'Total Terbayar',
                'value' => function ($model) {
                    return Utils::idrPrice($model['paid']);
                }
            ],
            [
                'attribute' => 'prosen',
                'header' => 'Prosen',
                'format' => 'raw',
                'value' => function ($model) {
                    return TrsRent::bagdeProsen($model['prosen']);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idtrsrent' => $model['idtrsrent']]);
                }
            ],
        ],
    ]);
    ?>


</div>
