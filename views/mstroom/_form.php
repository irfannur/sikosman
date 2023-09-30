<?php

use app\models\MstBuilding;
use app\models\MstRoom;
use kartik\date\DatePicker;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

/** @var View $this */
/** @var MstRoom $model */
/** @var ActiveForm $form */
?>

<div class="mst-room-form"><br>

    <?php $form = ActiveForm::begin(['layout' => 'horizontal', // Set the layout to 'horizontal'
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2', // Set the column width for labels
                'offset' => 'col-sm-offset-2', // Set the offset width for input fields
                'wrapper' => 'col-sm-10', // Set the column width for input fields
                'error' => '', // Leave this empty to suppress error messages for now
                'hint' => '', // Leave this empty to suppress hints for now
            ],
        ],]); ?>

    <div class="row">

        <div class="col-md-6">

            <?=
            $form->field($model, 'idbuilding')->widget(Select2::classname(), [
                'data' => MstBuilding::getListBuilding(),
                'options' => [
                    'id' => 'idbuilding',
                    'class' => 'form-control',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
            ?>

            <?= $form->field($model, 'roomname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'roomnumber')->textInput() ?>

            <?php
            echo $form->field($model, 'price')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'prefix' => 'Rp ',
                    'suffix' => '',
                    'allowNegative' => false
                ]
            ]);
            ?>

            <?= $form->field($model, 'height')->textInput() ?>

            <?= $form->field($model, 'weight')->textInput() ?>

        </div>

        <div class="col-md-6">

            <?=
            $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => MstRoom::getListStatus(),
                'options' => [
                    'id' => 'status',
                    'class' => 'form-control',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
            ?>

            <?=
            $form->field($model, 'lastrepair')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tanggal'],
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
