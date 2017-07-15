<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Configempresasindex */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="table-responsive"  align="center">
<?php $form = ActiveForm::begin(['id' => 'form-receptores', 'method'=>'post',
                                        'layout'=>'horizontal', 'fieldConfig' => [
			                                            'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			                                            /*'labelOptions' => ['class'=>''],*/
			                                            'horizontalCssClasses' => [
			                                                'label' => 'col-sm-4',
			                                                'offset' => 'col-sm-offset-4',
			                                                'wrapper' => 'col-sm-12',
			                                                'error' => '',
			                                                'hint' => '',
                                            ],
                                        ],
            		]) 
?>
    
    <div class="col-sm-12">
    <div class="col-sm-12">
		<?= $form->field($model, 'fchdde')->widget(DatePicker::className(), [
												'inline' => false,
												'language' => 'es',
												'size' => 'md',
												'template' => '<span class="input-group-addon colorLabel">Desde</span>{input}',
// 												 'template' => '{addon}{input}',
												'clientOptions' => [
													'autoclose' => true,
						// 							'format' => 'yyyy-mm-dd',
													'format' => 'dd/mm/yyyy',
												
										    		],
												]) 
		?>
	</div>
	</div>
    <div class="col-sm-12">
	<div class="col-sm-12">
		<?= $form->field($model, 'fchhta')->widget(DatePicker::className(), [
												'inline' => false,
												'language' => 'es',
												'size' => 'md',
												'template' => '<span class="input-group-addon colorLabel">Hasta</span>{input}',
// 												 'template' => '{addon}{input}',
												'clientOptions' => [
													'autoclose' => true,
						// 							'format' => 'yyyy-mm-dd',
													'format' => 'dd/mm/yyyy',
												
										    		],
												]) 
		?>
	</div>

	</div>	
	<div class="col-sm-12" align="center">
    	<?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-success', 'name' => 'update-button']) ?>
	</div>

    <?php ActiveForm::end(); ?>
</div>

