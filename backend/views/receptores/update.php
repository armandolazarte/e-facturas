<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Receptores */

$this->title = 'Actualizar Receptor: ' . ' ' . $model->receptorid;
$this->params['breadcrumbs'][] = ['label' => 'Receptores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->receptorid, 'url' => ['view', 'id' => $model->receptorid]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="receptores-update">

    <div align="center">
    <h3><?= Html::encode($this->title) ?></h3>
    </div>
	<br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
