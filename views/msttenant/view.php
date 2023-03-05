<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MstTenant $model */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Anak Kos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mst-tenant-view">

    <p class="float-right">
        <?= Html::a('Update', ['update', 'idtenant' => $model->idtenant], ['class' => 'btn btn-primary btn-sm']) ?>
        <?=
        Html::a('Delete', ['delete', 'idtenant' => $model->idtenant], [
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
            'idtenant',
            'nik',
            'name',
            'address',
            'dob',
            'startin',
            'endin',
            'note:ntext',
            'status',
            'lastpayment',
        ],
    ])
    ?>

</div>
