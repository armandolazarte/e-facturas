<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ComprobantesEnvio */

$this->title = 'Create Comprobantes Envio';
$this->params['breadcrumbs'][] = ['label' => 'Comprobantes Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comprobantes-envio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
