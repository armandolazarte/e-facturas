<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ComprobantesEnvioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comprobantes-envio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'comprobanteenvioid') ?>

    <?= $form->field($model, 'empresaid') ?>

    <?= $form->field($model, 'puntoventaid') ?>

    <?= $form->field($model, 'comprobanteid') ?>

    <?= $form->field($model, 'comprobantenro') ?>

    <?php // echo $form->field($model, 'fechaenvio') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'errores') ?>

    <?php // echo $form->field($model, 'fecha_rechazo') ?>

    <?php // echo $form->field($model, 'estadoid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
