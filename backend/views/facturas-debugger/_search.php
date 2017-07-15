<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FacturasDebuggerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturas-debugger-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'facturaid') ?>

    <?= $form->field($model, 'height_barcode') ?>

    <?= $form->field($model, 'width_barcode') ?>

    <?= $form->field($model, 'font_barcode') ?>

    <?= $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
