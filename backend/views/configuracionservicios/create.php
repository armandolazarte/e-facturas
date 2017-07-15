<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Configuracionservicios */

// $this->title = 'Create Configuracionservicios';
$this->params['breadcrumbs'][] = ['label' => 'Configuracion Servicios'];
$this->params['breadcrumbs'][] = 'Agregar';
?>
<div class="configuracionservicios-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
