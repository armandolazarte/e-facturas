<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EmpresasEmailSender */

// $this->title = 'Actualizar Email Notificaciones';
// $this->params['breadcrumbs'][] = ['label' => 'Empresas Email Senders', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->empresaid, 'url' => ['view', 'id' => $model->empresaid]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="empresas-email-sender-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
