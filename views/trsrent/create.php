<?php

use app\models\MstBuilding;
use app\models\MstRoom;
use app\models\MstTenant;
use app\models\RefRentperiod;
use app\models\TrsRent;
use app\models\TrsRentdet;
use app\models\User;
use app\models\Users;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var View $this */
/** @var TrsRent $model */
$this->title = 'Tambah Sewa';
$this->params['breadcrumbs'][] = ['label' => 'Sewa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trs-rent-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="trs-rent-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6">
                <?=
                $form->field($model, 'idbuilding')->widget(Select2::classname(), [
                    'data' => Users::getUserBuilding(User::me()->iduser, true),
                    'options' => [
                        'id' => 'idbuilding',
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', '--Pilih--'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])
                ?>

                <?=
                $form->field($model, 'idroom')->widget(DepDrop::classname(), [
                    'data' => MstRoom::getListRoom($model->idbuilding),
                    'type' => DepDrop::TYPE_SELECT2,
                    'options' =>
                    [
                        'id' => 'idroom',
                        'placeholder' => Yii::t('app', '--Pilih--'),
                    ],
                    'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                    'pluginOptions' => [
                        'depends' => ['idbuilding'],
                        'url' => Url::to(['/mstroom/ajax_listroom']),
                        'placeholder' => Yii::t('app', '--Pilih--'),
                        'allowClear' => false,
                    ]
                ])
                ?>

                <?=
                $form->field($model, 'idtenant')->widget(DepDrop::classname(), [
                    'data' => MstTenant::getListTenant($model->idbuilding),
                    'type' => DepDrop::TYPE_SELECT2,
                    'options' =>
                    [
                        'id' => 'idtenant',
                        'placeholder' => Yii::t('app', '--Pilih--'),
                    ],
                    'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                    'pluginOptions' => [
                        'depends' => ['idbuilding'],
                        'url' => Url::to(['/msttenant/ajax_listtenant']),
                        'placeholder' => Yii::t('app', '--Pilih--'),
                        'allowClear' => false,
                    ]
                ])
                ?>

                <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
            </div>
            <div class="col-md-6 form-agreement">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        echo $form->field($model, 'idrentperiod')->widget(Select2::classname(), [
                            'data' => RefRentperiod::getListPeriod(),
                            'options' => [
                                'id' => 'idrentperiod',
                                'class' => 'form-control form-rentperiod',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])
                        ?>

                        <?php
                        echo $form->field($model, 'agreeprice')->widget(MaskMoney::classname(), [
                            'options' => ['class' => 'form-agreeprice'],
                            'pluginOptions' => [
                                'prefix' => 'Rp ',
                                'suffix' => '',
                                'allowNegative' => false,
                                'allowZero' => false,
                            ]
                        ]);
                        ?>

                        <?=
                        $form->field($model, 'startrent')->widget(DatePicker::classname(), [
                            //'options' => ['placeholder' => 'Tanggal'],
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'dayplan')->dropdownList(TrsRent::getListDayplan(), ['class' => 'form-control form-dayplan'])->label('Sewa Untuk Berapa') ?>

                        <?php
                        echo $form->field($model, 'pretotal')->widget(MaskMoney::classname(), [
                            'options' => ['class' => 'form-pretotal'],
                            'readonly' => true,
                            'pluginOptions' => [
                                'prefix' => 'Rp ',
                                'suffix' => '',
                                'allowNegative' => false,
                                'allowZero' => false,
                            ]
                        ]);
                        ?>

                        <?=
                        $form->field($model, 'injurydate')->widget(DatePicker::classname(), [
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>

                    </div>

                </div>
                <?php
                $m_rentdet = new TrsRentdet();
                echo $form->field($m_rentdet, 'paid')->widget(MaskMoney::classname(), [
                    'pluginOptions' => [
                        'prefix' => 'Rp ',
                        'suffix' => '',
                        'allowNegative' => false,
                        'allowZero' => false,
                    ]
                ]);
                ?>

            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php
        ActiveForm::end();
        $css = " .form-agreement {    
            background-color: #e9ecef;
            padding: 10px 12px;
            border-radius: 5px;}
        ";
        $this->registerCss($css);
        ?>

    </div>
</div>

<?php JSRegister::begin() ?>
<script>

    const getTotalprice = (dayplan, agreeprice) => {
        var rdayplan = parseFloat(dayplan);
        var ragreeprice = parseFloat(agreeprice);

        if (rdayplan && ragreeprice) {
            var res = rdayplan * ragreeprice;
            return 'Rp ' + commafy(res);
        }
    }

    $('#trsrent-agreeprice-disp').on("change keyup", function (event) {
        var dayplan = $('.form-dayplan').val();
        var agreeprice = $(this).maskMoney('unmasked')[0];
        var result = getTotalprice(dayplan, agreeprice);

        $('.form-pretotal').val(result);
    });
    
    $('.form-dayplan').on("change keyup", function (event) {
        var dayplan = $(this).val();
        var agreeprice = $('#trsrent-agreeprice-disp').maskMoney('unmasked')[0];
        var result = getTotalprice(dayplan, agreeprice);

        $('.form-pretotal').val(result);
    });
    
    $('.form-rentperiod').on("change keyup", function (event) {
        var dayplan = $('.form-dayplan').val();
        var agreeprice = $('#trsrent-agreeprice-disp').maskMoney('unmasked')[0];
        var result = getTotalprice(dayplan, agreeprice);

        $('.form-pretotal').val(result);
    });

    function commafy(num) {
        var str = num.toString().split('.');
        if (str[0].length >= 5) {
            str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1.');
        }
        if (str[1] && str[1].length >= 5) {
            str[1] = str[1].replace(/(\d{3})/g, '$1 ');
        }

        return str.join('.');
    }

</script>
<?php JSRegister::end() ?>

