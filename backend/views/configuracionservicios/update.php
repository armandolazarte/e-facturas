<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Configuracionservicios */

// $this->title = 'Update Configuracionservicios: ' . ' ' . $model->configid;
$this->params['breadcrumbs'][] = ['label' => 'Configuracion Servicios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->configid, 'url' => ['view', 'id' => $model->configid]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="configuracionservicios-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
