<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Configfactindex */

$this->title = 'Configuración Filtros Mis Facturas';
// $this->params['breadcrumbs'][] = ['label' => 'Configfactindices', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->empresaid, 'url' => ['view', 'id' => $model->empresaid]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="configfactindex-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
