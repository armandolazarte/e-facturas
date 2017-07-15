<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Configuracionservicios */
/* @var $form yii\widgets\ActiveForm */

?>

        <div class="row">
        <div class="col-sm-8">
            <?php $form = ActiveForm::begin(['id' => 'form-receptores', 'method'=>'post',
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
			<div class="col-lg-8">
            <hr>                                              
		    <?php // $form->field($model, 'empresaid')->textInput(['maxlength' => 20]) ?>

		    <?= $form->field($model, 'servicioid')->dropDownList($model->getServiciosArray(), ['prompt' => 'Seleccione Uno' ]);?>
		    <?php // $form->field($model, 'servicioid')->textInput() ?>
		
		    <?php // $form->field($model, 'fecha')->textInput() ?>
		
		    <?= $form->field($model, 'carpeta')->textInput(['maxlength' => 8000]) ?>
		
		    <?= $form->field($model, 'carpetacae')->textInput(['maxlength' => 8000]) ?>
		
		    <?= $form->field($model, 'carpetaerror')->textInput(['maxlength' => 8000]) ?>
		
		    <?php // $form->field($model, 'produccion')->textInput() ?>

		    <hr>
		    <div class="pull-right">
	        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => ($this->params['breadcrumbs'][1] == 'Agregar') ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
	        
    	<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
