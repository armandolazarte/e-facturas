<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MensajesEmpresas */

$this->title = 'Crear Mensajes Empresas';
$this->params['breadcrumbs'][] = ['label' => 'Mensajes Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-empresas-create">

<div align="center">
    <h3><?= Html::encode($this->title) ?></h3>
</div>

    <?= $this->render('_form', [
				'empresas' => $empresas,
				'empresas_razon_razon' => $empresas_razon_razon,
                'model' => $model,
    ]) ?>

</div>
