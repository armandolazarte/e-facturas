<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FacturasDebugger */

$this->title = 'Create Facturas Debugger';
$this->params['breadcrumbs'][] = ['label' => 'Facturas Debuggers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturas-debugger-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
