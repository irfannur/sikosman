<?php

use app\models\MstTenant;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

/** @var View $this */
/** @var MstTenant $model */
/** @var ActiveForm $form */
?>

<div class="mst-tenant-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nik')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            <?=
            $form->field($model, 'dob')->widget(DatePicker::classname(), [
                //'options' => ['placeholder' => 'Tanggal Lahir'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
            
            <?=
            $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => MstTenant::getListStatus(),
                'options' => [
                    'id' => 'status',
                    'class' => 'form-control',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
            ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'startin')->widget(DatePicker::classname(), [
                //'options' => ['placeholder' => 'Tanggal Masuk'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?=
            $form->field($model, 'endin')->widget(DatePicker::classname(), [
                //'options' => ['placeholder' => 'Tanggal Keluar'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
        </div>
    </div>





    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
