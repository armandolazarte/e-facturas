<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VistasAudita */

$this->title = 'Update Vistas Audita: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vistas Audita', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vistas-audita-update">


<div class="col-sm-1">
</div>
<div class="col-sm-10">

    <?= $this->render('_form', [
        'model' => $model,
    		'vista' => $vista,
    		'empresa' => $empresa,    		
    ]) ?>
</div>

<div class="col-sm-1">
</div>
</div>
