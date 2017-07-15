<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EstadosConfiguracionFe */

$this->title = 'Actualizar: ' . ' ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Estados Configuracion FE', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estados-configuracion-fe-update">

<div align="center">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
<br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
