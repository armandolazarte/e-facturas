<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmpresasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'empresaid') ?>

    <?= $form->field($model, 'nrocuit') ?>

    <?= $form->field($model, 'razonsocial') ?>

    <?= $form->field($model, 'nroiibb') ?>

    <?= $form->field($model, 'inicioact') ?>

    <?php // echo $form->field($model, 'prestadorid') ?>

    <?php // echo $form->field($model, 'responsableid') ?>

    <?php // echo $form->field($model, 'calle') ?>

    <?php // echo $form->field($model, 'nro') ?>

    <?php // echo $form->field($model, 'piso') ?>

    <?php // echo $form->field($model, 'depto') ?>

    <?php // echo $form->field($model, 'cp') ?>

    <?php // echo $form->field($model, 'manzana') ?>

    <?php // echo $form->field($model, 'localidad') ?>

    <?php // echo $form->field($model, 'sector') ?>

    <?php // echo $form->field($model, 'provinciaid') ?>

    <?php // echo $form->field($model, 'torre') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'cuponpf') ?>

    <?php // echo $form->field($model, 'gln') ?>

    <?php // echo $form->field($model, 'fechabaja') ?>

    <?php // echo $form->field($model, 'cuitasociado') ?>

    <?php // echo $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
