<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Puntosventa */
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

    		<?= $form->field($model, 'puntoventa')->textInput(['maxlength' => 45]) ?>

	    	<?= $form->field($model, 'descripcion')->textInput(['maxlength' => 255]) ?>

	    	<hr>
	    	<div align="right">
	        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
	        
            <?php ActiveForm::end();?>
            </div>
        </div>

</div>