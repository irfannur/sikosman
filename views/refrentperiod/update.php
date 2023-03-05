<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RefRentperiod $model */

$this->title = 'Update Ref Rentperiod: ' . $model->idrentperiod;
$this->params['breadcrumbs'][] = ['label' => 'Ref Rentperiods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idrentperiod, 'url' => ['view', 'idrentperiod' => $model->idrentperiod]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-rentperiod-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
