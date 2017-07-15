<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ConfiguracionserviciosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuracionservicios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'configid') ?>

    <?= $form->field($model, 'empresaid') ?>

    <?= $form->field($model, 'servicioid') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'carpeta') ?>

    <?php // echo $form->field($model, 'carpetacae') ?>

    <?php // echo $form->field($model, 'carpetaerror') ?>

    <?php // echo $form->field($model, 'produccion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
