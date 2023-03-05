<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\RefRentperiod $model */

$this->title = $model->idrentperiod;
$this->params['breadcrumbs'][] = ['label' => 'Ref Rentperiods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ref-rentperiod-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idrentperiod' => $model->idrentperiod], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idrentperiod' => $model->idrentperiod], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idrentperiod',
            'rentperiodname',
            'rentperiodalias',
            'price',
            'lastupdated',
            'ordering',
            'day',
        ],
    ]) ?>

</div>
