<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MensajesEmpresasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensajes-empresas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mensajeid') ?>

    <?= $form->field($model, 'empresaid') ?>

    <?= $form->field($model, 'empresa') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'sizetitulo') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'textalign') ?>

    <?php // echo $form->field($model, 'colorfondo') ?>

    <?php // echo $form->field($model, 'vista') ?>

    <?php // echo $form->field($model, 'vigenciadesde') ?>

    <?php // echo $form->field($model, 'vigenciahasta') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'permitecerrar') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
