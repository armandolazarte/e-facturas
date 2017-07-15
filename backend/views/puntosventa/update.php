<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Puntosventa */

$this->title = 'Actualizar Punto Venta: ' . ' <a>' . $model->puntoventa . '</a>';
$this->params['breadcrumbs'][] = ['label' => 'Puntos de Venta', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->puntoventa, 'url' => ['view', 'id' => $model->puntoventaid]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="puntosventa-update">

    <h4><?= $this->title ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
