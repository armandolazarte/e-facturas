<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceptoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receptores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'receptorid') ?>

    <?= $form->field($model, 'documentoid') ?>

    <?= $form->field($model, 'cuit') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'localidad') ?>

    <?php // echo $form->field($model, 'provinciaid') ?>

    <?php // echo $form->field($model, 'responsableid') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'mail') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
