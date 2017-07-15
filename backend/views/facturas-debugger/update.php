<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FacturasDebugger */

$this->title = 'Update Facturas Debugger: ' . ' ' . $model->facturaid;
$this->params['breadcrumbs'][] = ['label' => 'Facturas Debuggers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->facturaid, 'url' => ['view', 'id' => $model->facturaid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="facturas-debugger-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
