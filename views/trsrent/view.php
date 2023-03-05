<?php

use app\helpers\DateUtils;
use app\helpers\HtmlUtils;
use app\helpers\Utils;
use app\models\TrsRent;
use kartik\grid\GridView;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var View $this */
/** @var TrsRent $model */
$this->title = $model->idtenant0->name . ' (' . $model->idroom0->roomname . ')';
$this->params['breadcrumbs'][] = ['label' => 'Sewa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="trs-rent-view">

    <p class="float-right">
        <?= Html::a('Update', ['update', 'idtrsrent' => $model->idtrsrent], ['class' => 'btn btn-primary btn-sm']) ?>
        <?=
        Html::a('Delete', ['delete', 'idtrsrent' => $model->idtrsrent], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <h3><?= Html::encode($this->title) ?></h3>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Kamar',
                'value' => function ($model) {
                    return $model->idroom0->roomname . ' ' . $model->idroom0->roomnumber . ' (' . $model->idroom0->idbuilding0->buildingname . ')';
                }
            ],
            [
                'label' => 'Anak Kos',
                'value' => function ($model) {
                    return $model->idtenant0->name . ' (' . $model->idtenant0->nik . ')';
                }
            ],
            'rentperiodname',
            [
                'label' => 'Waktu Sewa',
                'value' => function ($model) {
                    return $model->dayplan . ' ' . substr($model->rentperiodname, 0, -2);
                }
            ],
            [
                'label' => 'Harga Yang Disepakati',
                'format' => 'raw',
                'value' => function ($model) {
                    return Utils::idrPrice($model->agreeprice) . ' <code>(harga per' . strtolower(substr($model->rentperiodname, 0, -2)) . ')</code>';
                }
            ],
            [
                'label' => 'Total Yang Harus Dibayar',
                'format' => 'raw',
                'value' => function ($model) {
                    return Utils::idrPrice($model->pricetotal);
                }
            ],
            [
                'label' => 'Kurang Bayar',
                'value' => function ($model) {
                    return Utils::idrPrice($model->debt);
                }
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($model) {
                    return TrsRent::bagdeStatus($model->status);
                }
            ],
            [
                'label' => 'Tanggal Mulai Sewa',
                'value' => function ($model) {
                    return DateUtils::dateOnly($model->startrent);
                }
            ],
            [
                'label' => 'Tanggal Selesai Sewa',
                'value' => function ($model) {
                    return DateUtils::dateOnly(DateUtils::dateAddDay($model->startrent, $model->daytotal));
                }
            ],
            'note:ntext',
        ],
    ])
    ?>

    <?= HtmlUtils::lineTextCenter('Rincian Pembayaran') ?>

    <?= Html::a('<span class="fa fa-plus"></span> Bayar', '#', ['url' => Url::to(['addpaid', 'idtrsrent' => $model->idtrsrent], true), 'class' => 'btn-modal btn btn-success btn-sm float-right mb-3']); ?>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'responsive' => true,
        'hover' => true,
        'showPageSummary' => true,
        'pageSummaryPosition' => GridView::POS_BOTTOM,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'pageSummary' => 'Total',
                'attribute' => 'paiddate',
                'value' => 'paiddate',
            ],
            [
                'attribute' => 'paid',
                'pageSummary' => true,
//                'pageSummaryOptions' => [
//                    'prepend' => "Rp ",
//                ],
                'value' => function ($model) {
                    return Utils::idrPrice($model->paid);
                },
                'pageSummaryFunc' => function ($data) {

                    array_walk($data, function (&$v) {
                        $v = str_replace(['.', ',', 'Rp'], ['', '.', ''], $v);
                    });
                    return Utils::idrPrice(array_sum($data));
                },
            ],
            'note',
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    if ($action == 'delete') {
                        return ['trsrent/deldet', 'id' => $model['idtrsrentdet']];
                    }
                }
            ],
        ],
    ]);

    $datadet = $dataProvider->getModels();
    $terbayar = array_sum(ArrayHelper::getColumn($datadet, 'paid'));
    $kurang = $model->pricetotal - $terbayar;
    ?>

    <div class="alert alert-info">
        Kurang bayar
        <code><b><?= Utils::idrPrice($model->pricetotal) . ' - ' . Utils::idrPrice($terbayar) . ' = ' . Utils::idrPrice($kurang) ?></b></code>
    </div>

    <?php
    Modal::begin([
        'title' => '<h3 class="modal-title">Pelunasan</h3>',
        'id' => 'modal-form-paid',
        'size' => 'modal-md',
        'options' => [
            'id' => 'modal-form',
            'tabindex' => false // important for Select2 to work properly
        ],
    ]);
    echo "<div id='modal-content'>Mohon tunggu ...</div>";
    Modal::end();

    JSRegister::begin();
    ?>
    <script>
        $('.btn-modal').click(function (e) {
            e.preventDefault();
            $('#modal-content').html('Mohon tunggu ...');
            $('#modal-form').modal('show');

            $.ajax({
                url: $(this).attr('url'),
                method: 'post',
                dataType: 'html',
                success: function (data) {
                    $('#modal-content').html(data);
                },
                error: function (xhr, error) {
                    $('#modal-form').modal('hide');
                    alert('Gagal, silakan coba kembali.');
                }

            });

        });
    </script>
    <?php JSRegister::end(); ?>
</div>
