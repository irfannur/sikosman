<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MstRoom $model */

$this->title = 'Update Kamar: ' . $model->idroom;
$this->params['breadcrumbs'][] = ['label' => 'Kamar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idroom, 'url' => ['view', 'idroom' => $model->idroom]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mst-room-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
