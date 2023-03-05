<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MstRoom $model */

$this->title = $model->roomname ? $model->roomname : $model->idroom;
$this->params['breadcrumbs'][] = ['label' => 'Kamar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mst-room-view">

    <p class="float-right">
        <?= Html::a('Update', ['update', 'idroom' => $model->idroom], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('Delete', ['delete', 'idroom' => $model->idroom], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<h2><?= Html::encode($this->title) ?></h2>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idroom',
            'roomname',
            'roomnumber',
            'idbuilding',
            'height',
            'weight',
            'status',
            'lastrepair',
            'note:ntext',
            'price',
        ],
    ]) ?>

</div>
