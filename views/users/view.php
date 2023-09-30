<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Users $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <p class="float-right">
        <?= Html::a('Update', ['update', 'iduser' => $model->iduser], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'iduser' => $model->iduser], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'iduser',
            'username',
            'password',
            'name',
            'role',
            'lastlogin',
            'userkey',
            'lastname',
            'email:email',
            'status',
            'phone',
        ],
    ]) ?>

    <hr>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //'idbuilding',
            'buildingname:ntext:Bangunan Kos',
        ],
    ]);
    ?>

</div>
