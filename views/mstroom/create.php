<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MstRoom $model */

$this->title = 'Tambah Kamar';
$this->params['breadcrumbs'][] = ['label' => 'Kamar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mst-room-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
