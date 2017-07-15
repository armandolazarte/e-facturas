<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Vistas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vistas-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <div class="col-sm-12">
    <br><br>
    <div class="col-sm-6">
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => 255]) ?>
    </div>
	<div class="col-sm-6">
    </div>
    </div>
    
	<div class="col-sm-12">
	<div class="col-sm-6">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
