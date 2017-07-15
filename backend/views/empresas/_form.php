<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Empresas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nrocuit')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'razonsocial')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'nroiibb')->textInput(['maxlength' => 13]) ?>

    <?= $form->field($model, 'inicioact')->textInput() ?>

    <?= $form->field($model, 'prestadorid')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'responsableid')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'calle')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'nro')->textInput(['maxlength' => 6]) ?>

    <?= $form->field($model, 'piso')->textInput(['maxlength' => 6]) ?>

    <?= $form->field($model, 'depto')->textInput(['maxlength' => 6]) ?>

    <?= $form->field($model, 'cp')->textInput(['maxlength' => 8]) ?>

    <?= $form->field($model, 'manzana')->textInput(['maxlength' => 6]) ?>

    <?= $form->field($model, 'localidad')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'sector')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'provinciaid')->textInput() ?>

    <?= $form->field($model, 'torre')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'cuponpf')->textInput() ?>

    <?= $form->field($model, 'gln')->textInput(['maxlength' => 13]) ?>

    <?= $form->field($model, 'fechabaja')->textInput() ?>

    <?= $form->field($model, 'cuitasociado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
