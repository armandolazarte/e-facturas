<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FacturasMensajesNotificacion */

$this->title = 'Create Facturas Mensajes Notificacion';
$this->params['breadcrumbs'][] = ['label' => 'Facturas Mensajes Notificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturas-mensajes-notificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
