<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\VistasAudita */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vistas-audita-form">

	<?php $form = ActiveForm::begin(['method'=>'post',
                                        'layout'=>'horizontal', 'fieldConfig' => [
			                                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			                                            /*'labelOptions' => ['class'=>''],*/
			                                            'horizontalCssClasses' => [
			                                                'label' => 'col-sm-4',
			                                                'offset' => 'col-sm-offset-4',
			                                                'wrapper' => 'col-sm-8',
			                                                'error' => '',
			                                                'hint' => '',
                                            ],
                                        ],
            		]); 
            ?>  

    <br><br>
    <div class="col-sm-12">
    <div class="col-sm-3">
    <?= $form->field($model, 'empresaid')->textInput(['maxlength' => 20, 'readonly' => true, 'style' => 'width: 50%;' ])->label(false) ?>
	</div>
	<div class="col-sm-9" style="font-size: 28px">
	<p><?= $empresa['razonsocial']?></p>
	</div>
	
	<div class="col-sm-3">
	</div>
	<div class="col-sm-9" style="font-size: 28px">
	<p>	<?= 'Vista: <b>' . $vista['descripcion'] . '</b>'?>	</p>	
	</div>
	
	</div>

	<div class="col-sm-12">
	<div class="col-sm-3">
	</div>
    <div class="col-sm-6">
    <?= $form->field($model, 'ultimo_ingreso')->textInput(['readonly' => true, 'style' => 'width: 75%;']) ?>
	</div>

    <div class="col-sm-3">
	</div>
	</div>	
	
	
	<div class="col-sm-12">
	<div class="col-sm-3">
	</div>
	<div class="col-sm-6">
    <?= $form->field($model, 'ingreso_anterior')->textInput(['readonly' => true, 'style' => 'width: 75%;']) ?>
	</div>
	<div class="col-sm-3">
	</div>
	</div>
	
	<div class="col-sm-12">
	<div class="col-sm-3">
	</div>
	<div class="col-sm-3">
    <?= $form->field($model, 'status')->inline(true)->radioList(array(1=>'Si', 0=>'No')) ?>
	</div>
	<div class="col-sm-3">
	<?= $form->field($model, 'contador')->textInput(['readonly' => true, 'style' => 'width: 75%;']) ?>
    </div>
	</div>

	<div class="col-sm-12">
	<div class="col-sm-3">
	</div>
	<div class="col-sm-3" align="left">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	</div>

	
	<?php ActiveForm::end(); ?>

</div>
