<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ConfigfactindexSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configfactindex-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'empresaid') ?>

    <?= $form->field($model, 'fchdde') ?>

    <?= $form->field($model, 'fchhta') ?>

    <?= $form->field($model, 'pagesize') ?>

    <?= $form->field($model, 'filtros') ?>

    <?php // echo $form->field($model, 'notificada_color_status') ?>

    <?php // echo $form->field($model, 'orden1_campo') ?>

    <?php // echo $form->field($model, 'orden1_tipo') ?>

    <?php // echo $form->field($model, 'orden2_campo') ?>

    <?php // echo $form->field($model, 'orden2_tipo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
