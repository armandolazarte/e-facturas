<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Empresas */

$this->title = 'Update Empresas: ' . ' ' . $model->empresaid;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->empresaid, 'url' => ['view', 'id' => $model->empresaid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="empresas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
