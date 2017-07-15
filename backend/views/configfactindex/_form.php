<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\Configfactindex */
/* @var $form yii\widgets\ActiveForm */
?>
<hr>
        
<div class="row">        
        
            <?php $form = ActiveForm::begin(['id' => 'form-receptores', 'method'=>'post',
                                        'layout'=>'horizontal', 'fieldConfig' => [
// 			                                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			                                            /*'labelOptions' => ['class'=>''],*/
// 			                                            'horizontalCssClasses' => [
// 			                                                'label' => 'col-sm-6',
// 			                                                'offset' => 'col-sm-offset-7',
// 			                                                'wrapper' => 'col-sm-6',
// 			                                                'error' => '',
// 			                                                'hint' => '',
//                                             ],
                                        ],
            		]); 
            ?>  
	<div class="col-sm-6 col-xs-7">

    <div align="center">
    <?php Modal::begin([
	        'header' => '<center><b>Rango de días</b></center>',
// 		    'size' => "modal-lg",
		    'closeButton' => false,
		    'toggleButton' => [
		    		'label' => 'Rango de días (Desde - Hasta)', 
		    		'class'=>'btn btn-default active'
				],
	    	]); 
    ?>  
		
		<div align="left">
		<b>
		Establezca el rango en días para visualizar las facturas por defecto.<br>
		</b>
		Ej. Puede indicar que se muestren las facturas de los últimos 30 días y los 10 días posteriores al día de hoy.
		</div>
		<br>
			<?= $form->field($model, 'fchdde', [
			        'inputTemplate' => 
						'<div class="input-group">
							<span class="input-group-addon">
								Mostrar facturas con 
							</span>
							{input}'.
			            	'<span class="input-group-addon">
								días anteriores al día de la fecha
							</span>
						</div>',
					'horizontalCssClasses' => [
							'label' => 'col-sm-1',
							'wrapper' => 'col-sm-10',
					]
			    ])
			    ->label('')
				->textInput(['maxlength' => 4]); 
			?>		    
			
			<?= $form->field($model, 'fchhta', [
			        'inputTemplate' => 
						'<div class="input-group">
							<span class="input-group-addon">
								Mostrar facturas con 
							</span>
							{input}'.
			            	'<span class="input-group-addon">
								días posteriores al día de la fecha
							</span>
						</div>',
					'horizontalCssClasses' => [
							'label' => 'col-sm-1',
							'wrapper' => 'col-sm-10',
					]
			    ])
			    ->label('')
				->textInput(['maxlength' => 3]);
			?>		    			

			
<!-- 			</div>					 -->
    <?php Modal::end();?>             	
	</div>		

    
	<br><p>
    <?= $form->field($model, 'pagesize')->dropDownList(['-1'=>'Sin paginación',
    		'10'=>'10 facturas',
    		'30'=>'30 facturas',    		
    		'50'=>'50 facturas',
    		'100'=>'100 facturas',
    		'200'=>'200 facturas',
    		'300'=>'300 facturas',
    		'500'=>'500 facturas',
    	//	'1000'=>'1000 facturas',
    	//	'3000'=>'3000 facturas',
    	//	'5000'=>'5000 facturas',
            ]); ?>

    <?= $form->field($model, 'filtros')->dropDownList(['0'=>'Amplio','1'=>'Compacto']); ?>

    <?= $form->field($model, 'notificada_color_status')->inline(true)->radioList(array(1=>'Si', 0=>'No')); ?>

    <?= $form->field($model, 'mostrar_impresas')->inline(true)->radioList(array(1=>'Si', 0=>'No')); ?>

    <?= $form->field($model, 'impresa_receptor')->inline(true)->radioList(array(1=>'Si', 0=>'No')); ?>
    
    </div>
    

    
	<div class="col-sm-6 col-xs-7">

    <?= $form->field($model, 'orden1_campo')->dropDownList(['comprobantenro'=>'NÚMERO','letra'=>'LETRA']); ?>

	<!--     SORT_DESC = 3   ---   SORT_ASC = 4    -->
    <?= $form->field($model, 'orden1_tipo')->dropDownList(['4'=>'ASCENDENTE','3'=>'DESCENDENTE']); ?>

    <?= $form->field($model, 'orden2_campo')->dropDownList(['comprobantenro'=>'NÚMERO','letra'=>'LETRA']); ?>

    <?= $form->field($model, 'orden2_tipo')->dropDownList(['4'=>'ASCENDENTE','3'=>'DESCENDENTE']); ?>
	
	</div>
	
	<div class="col-sm-6 col-xs-7">
	<br><br>
	</div>

	<div class="col-sm-6 col-xs-7">
	<br><br>
	</div>
	
	<div class="col-sm-6 col-xs-7">
	<br><br>
	</div>
	
	
	<div class="col-sm-6 col-xs-7" align="right">
	<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>