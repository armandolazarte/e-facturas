<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ComprobantesEnvio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comprobantes-envio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'empresaid')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'puntoventaid')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'comprobanteid')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'comprobantenro')->textInput() ?>

    <?= $form->field($model, 'fechaenvio')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => 8000]) ?>

    <?= $form->field($model, 'errores')->textInput(['maxlength' => 8000]) ?>

    <?= $form->field($model, 'fecha_rechazo')->textInput() ?>

    <?= $form->field($model, 'estadoid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
