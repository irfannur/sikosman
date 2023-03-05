<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MstTenant $model */

$this->title = 'Update : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Anak Kos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'idtenant' => $model->idtenant]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mst-tenant-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
