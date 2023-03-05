<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RefRentperiod $model */

$this->title = 'Create Ref Rentperiod';
$this->params['breadcrumbs'][] = ['label' => 'Ref Rentperiods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-rentperiod-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
