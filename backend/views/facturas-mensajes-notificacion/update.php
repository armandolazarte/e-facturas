<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FacturasMensajesNotificacion */

$this->title = 'Update Facturas Mensajes Notificacion: ' . ' ' . $model->facturaid;
$this->params['breadcrumbs'][] = ['label' => 'Facturas Mensajes Notificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->facturaid, 'url' => ['view', 'id' => $model->facturaid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="facturas-mensajes-notificacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
