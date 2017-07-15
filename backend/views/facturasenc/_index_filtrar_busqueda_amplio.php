<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Formato;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
?>

				 	<?php
				    Modal::begin([
					'header' => '<center><b><span class="glyphicon glyphicon-search"></span> Filtrar Busqueda </b></center>',
					//'size' => "modal-sm",
		    		'toggleButton' => [
		    		'onclick'=>'setTimeout("document.getElementById(\"facturasform-receptor\").focus()", 600);',
		    		'label' => '<span class="glyphicon glyphicon-search"></span> Filtrar Busqueda', 
		    		'class'=>'btn btn-success'],
				    ]); ?>  
				
				    <div class="row">
				        <div class="col-sm-10">
				            <?php $form = ActiveForm::begin(['id' => 'form-facturas', 
// 				            		"onload"=>"document.getElementById('facturasform-receptor').focus();",
				            		'method'=>'post',
				                                        'layout'=>'horizontal', 
				            		'fieldConfig' => [
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
				            ]) ?>
				            
						                <?= $form->field($search, 'fchdde')->widget(DatePicker::className(), [
												'inline' => false,
												'language' => 'es',
												'size' => 'sm',
												 'template' => '{addon}{input}',
												'clientOptions' => [
													'autoclose' => true,
						// 							'format' => 'yyyy-mm-dd',
													'format' => 'dd/mm/yyyy',
												
										    		],
												]) 
						                ?>
						                <?= $form->field($search, 'fchhta')->widget(DatePicker::className(), [
												'inline' => false,
												'language' => 'es',
												'size' => 'sm',
												 'template' => '{addon}{input}',
												'clientOptions' => [
													'autoclose' => true,
						// 							'format' => 'yyyy-mm-dd',
													'format' => 'dd/mm/yyyy',
												
										    		],
												]) 
				                ?>				                
					
				                <?php //echo $form->field($search, 'fchdde')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) ?>
				                <?php //echo $form->field($search, 'fchhta')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) ?>
				                
				                <?= $form->field($search, 'receptor') ?>                
				                <?= $form->field($search, 'comprobante')->dropDownList($listComprobantes,[]) ?>
				
				                <?= $form->field($search, 'nrodde') ?>
				                <?= $form->field($search, 'nrohta') ?>
				 
							    <?= $form->field($search, 'puntoventa') ?>
				                <?= $form->field($search, 'notificada')->dropDownList(['-1'=>'todos','0'=>'no','1'=>'si']); ?>
				                <?= $form->field($search, 'impresacli')->dropDownList(['-1'=>'todos','0'=>'no impresa','1'=>'impresa'])?>
				                <?= $form->field($search, 'impresa')->dropDownList(['-1'=>'todos','0'=>'no impresa','1'=>'impresa'])?>
				               
				                <div class="form-group" align="right">
<!-- 				                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
				                    <?= Html::button('<span class="glyphicon glyphicon-trash"></span>', [
						                'class' => 'btn btn-danger', 
						                'name' => 'reset-button',
										'onclick'=>'
												var frm = document.getElementById("form-facturas");
												for (i=0;i<frm.elements.length;i++)
												{
													if (frm.elements[i].type == "text") {
														frm.elements[i].value = "";
											    	}
													else if (frm.elements[i].type == "select-one") {
														if (frm.elements[i].id == "facturasform-comprobante") {
															frm.elements[i].value = 0;
														}
														else {
															frm.elements[i].value = -1;
														}
											    	}
												}
		
												document.getElementById("facturasform-receptor").focus();
												'
										]) 
									?>		
				                	<?= Html::resetButton('<span class="glyphicon glyphicon-refresh"></span>', [
				                		'class' => 'btn btn-success', 
				                		'name' => 'reset-button',
				                		'onclick'=>"document.getElementById('facturasform-receptor').focus()"
										]
				            		)
				            		?>																			                    
				                    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
				                </div>
				            <?php ActiveForm::end(); ?>
				        </div>
				    </div>
				    
				    
				    <?php 
					    Modal::end();
				    ?>