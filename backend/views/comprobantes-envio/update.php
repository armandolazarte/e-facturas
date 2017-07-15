<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ComprobantesEnvio */

$this->title = 'Update Comprobantes Envio: ' . ' ' . $model->comprobanteenvioid;
$this->params['breadcrumbs'][] = ['label' => 'Comprobantes Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->comprobanteenvioid, 'url' => ['view', 'id' => $model->comprobanteenvioid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comprobantes-envio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
