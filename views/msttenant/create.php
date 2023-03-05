<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MstTenant $model */

$this->title = 'Tambah';
$this->params['breadcrumbs'][] = ['label' => 'Anak Kos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mst-tenant-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
