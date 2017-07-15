<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Mails */

$this->title = 'Actualizar Email: ' . ' <a>' . $model->mail . '</a>';
$this->params['breadcrumbs'][] = ['label' => 'Emails', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->mailid, 'url' => ['view', 'id' => $model->mailid]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="mails-update">

    <h4><?= $this->title ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
