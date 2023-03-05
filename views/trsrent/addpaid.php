<?php

use app\models\TrsRent;
use kartik\date\DatePicker;
use kartik\money\MaskMoney;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var TrsRent $model */
$this->title = 'Update Trs Rent: ' . $model->idtrsrent;
$this->params['breadcrumbs'][] = ['label' => 'Trs Rents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtrsrent, 'url' => ['view', 'idtrsrent' => $model->idtrsrent]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trs-rent-update">

    <?php
    $form = ActiveForm::begin();
    $model->paiddate = date('Y-m-d H:i:s');
    echo $form->field($model, 'paiddate')->widget(DatePicker::classname(), [
        //'options' => ['placeholder' => 'Tanggal'],
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]);

    echo $form->field($model, 'paid')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => 'Rp ',
            'suffix' => '',
            'allowNegative' => false,
            'allowZero' => false,
        ]
    ]);
    
    echo $form->field($model, 'note')->textarea(['rows' => 4]);
    ?>

    <div class="form-group float-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
