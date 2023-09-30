<?php

use app\helpers\Rolename;
use app\models\MstBuilding;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="users-form"><br>

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

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList(Rolename::listRole()) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'idbuildings')->widget(Select2::classname(), [
        'data' => MstBuilding::getListBuilding(),
        'options' => [
            'id' => 'idbuilding',
            'class' => 'form-control',
            'placeholder' => Yii::t('app', '--Pilih--'),
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>

    <div class="form-group float-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerCss(".select2-container .select2-search--inline {
    float: none;
}")
?>
