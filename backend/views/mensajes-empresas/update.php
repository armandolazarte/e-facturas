<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MensajesEmpresas */

$this->title = 'Actualizar Mensaje Empresa: ' . ' ' . $model->empresaid;
$this->params['breadcrumbs'][] = ['label' => 'Mensajes Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mensajeid, 'url' => ['view', 'id' => $model->mensajeid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mensajes-empresas-update">

<div align="center">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
    <?= $this->render('_form', [
    		'empresas' => $empresas,
				'empresas_razon_razon' => $empresas_razon_razon,
                'model' => $model,
    ]) ?>

</div>
