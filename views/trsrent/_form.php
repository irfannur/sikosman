<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TrsRent $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="trs-rent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idtrsrent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idroom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idtenant')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agreeprice')->textInput() ?>

    <?= $form->field($model, 'rentdate')->textInput() ?>

    <?= $form->field($model, 'debt')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'day')->textInput() ?>

    <?= $form->field($model, 'dayplan')->textInput() ?>

    <?= $form->field($model, 'daytotal')->textInput() ?>

    <?= $form->field($model, 'pricetotal')->textInput() ?>

    <?= $form->field($model, 'rentperiodname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'startrent')->textInput() ?>

    <?= $form->field($model, 'endrent')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
