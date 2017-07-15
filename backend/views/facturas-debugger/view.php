<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FacturasDebugger */

$this->title = $model->facturaid;
$this->params['breadcrumbs'][] = ['label' => 'Facturas Debuggers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturas-debugger-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->facturaid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->facturaid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'facturaid',
            'height_barcode',
            'width_barcode',
            'font_barcode',
            'status',
        ],
    ]) ?>

</div>
