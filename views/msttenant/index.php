<?php

use app\models\MstTenant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Anak Kos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mst-tenant-index">


    <p class="float-right">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    <h3><?= Html::encode($this->title) ?></h3>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'idtenant',
            'nik',
            'name',
            'address',
            'dob',
            'startin',
            'endin',
            'note:ntext',
            'status',
            //'lastpayment',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MstTenant $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idtenant' => $model->idtenant]);
                }
            ],
        ],
    ]);
    ?>


</div>
