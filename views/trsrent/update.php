<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TrsRent $model */

$this->title = 'Update Trs Rent: ' . $model->idtrsrent;
$this->params['breadcrumbs'][] = ['label' => 'Trs Rents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtrsrent, 'url' => ['view', 'idtrsrent' => $model->idtrsrent]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trs-rent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
