<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VistasAuditaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vistas-audita-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'empresaid') ?>

    <?= $form->field($model, 'vistaid') ?>

    <?= $form->field($model, 'ultimo_ingreso') ?>

    <?= $form->field($model, 'ingreso_anterior') ?>
    
    <?= $form->field($model, 'contador') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
