<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RefRentperiod $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ref-rentperiod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idrentperiod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rentperiodname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rentperiodalias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'lastupdated')->textInput() ?>

    <?= $form->field($model, 'ordering')->textInput() ?>

    <?= $form->field($model, 'day')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
