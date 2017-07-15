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
			    		'onclick'=>'
		
								javascript:if(
												((parseInt(document.getElementById("facturasform-notificada").value)+1) +
												(parseInt(document.getElementById("facturasform-impresacli").value)+1) +
												(parseInt(document.getElementById("facturasform-impresa").value)+1) +		
												(document.getElementById("facturasform-puntoventa").value.length)) > 0
											) {
												$("#btn-filtros").removeClass("btn btn-default active");
												$("#btn-filtros").addClass("btn-black");
    										}
											else {
													$("#btn-filtros").removeClass("btn-black");
													$("#btn-filtros").addClass("btn btn-default active");
											}
											
											if((document.getElementById("facturasform-fchdde").value + document.getElementById("facturasform-fchhta").value).length > 0) {
													$("#btn-fecha").removeClass("btn btn-default active");
													$("#btn-fecha").addClass("btn-black");
    										}
											else {
													$("#btn-fecha").removeClass("btn-black");													
													$("#btn-fecha").addClass("btn btn-default active");
											}				
		
											if((document.getElementById("facturasform-nrodde").value + document.getElementById("facturasform-nrohta").value).length > 0) {
													$("#btn-nro").removeClass("btn btn-default active");
													$("#btn-nro").addClass("btn-black");
    										}
											else {
													$("#btn-nro").removeClass("btn-black");
													$("#btn-nro").addClass("btn btn-default active");
											}					
							
						setTimeout("document.getElementById(\"facturasform-receptor\").focus()", 600);
						
						',
		    			
		    			'label' => '<span class="glyphicon glyphicon-search"></span> Filtrar Busqueda', 
		    			'class'=>'btn btn-success',
					],
			    ]); ?>  
			
			    <div class="row">
			        <div class="col-sm-10">
			            <?php $form = ActiveForm::begin(['id' => 'form-facturas', 'method'=>'post',
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
			            
						<!-- -------------------------  ini FECHAS  ------------------------------------------------ -->
			            	<br>
			            	<p style="text-indent: 95px;">
			            	<b>Fecha</b> 
			            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			            	<?php
							    Modal::begin([
							        'header' => '<center><b> Fecha </b></center>',
								    'size' => "modal-sm",
								    'closeButton' => false,
								    'toggleButton' => [
								    	'id' => 'btn-fecha',
								    	'label' => 'Desde - Hasta', 
								    	'class'=>'btn btn-default active',
								    	'onfocus'=>'javascript:if((document.getElementById("facturasform-fchdde").value + document.getElementById("facturasform-fchhta").value).length > 0) {
													$("#btn-fecha").removeClass("btn btn-default active");
													$("#btn-fecha").addClass("btn-black");
    										}
											else {
													$("#btn-fecha").removeClass("btn-black");													
													$("#btn-fecha").addClass("btn btn-default active");
											}
										',                  
											    	'onclick'=>'setTimeout("document.getElementById(\"facturasform-fchdde\").focus()", 530);
													',
										],
							    	]); 
						    ?>  
					                
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
											])->label('Desde')
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
											])->label('Hasta')
			                ?>				                
				
						    <?php 
							    Modal::end();
						    ?>             
						    </p>
						    <br>
						<!-- -------------------------  fin FECHAS  ------------------------------------------------ -->			    
			                
			                
			                <?php //echo $form->field($search, 'fchdde')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) ?>
			                <?php //echo $form->field($search, 'fchhta')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) ?>
			                
			                <?= $form->field($search, 'receptor')->textInput(['title' => 'Nombre, Dirección o Código de Cliente']) ?>                
			                <?= $form->field($search, 'comprobante')->dropDownList($listComprobantes,[]) ?>
			
			                <!-- -------------------------  ini NUMEROS ------------------------------------------------ -->
			            	<p style="text-indent: 85px;">
			            	<b>Número</b> 
			            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            	<?php
							    Modal::begin([
							    	'header' => '<center><b> Número </b></center>',
								    'size' => "modal-sm",
								    'closeButton' => false,
								    'toggleButton' => [
								    	'id' => 'btn-nro',
								    	'label' => 'Desde - Hasta', 
								    	'class'=>'btn btn-default active',
								    	'onfocus'=>'javascript:if((document.getElementById("facturasform-nrodde").value + document.getElementById("facturasform-nrohta").value).length > 0) {
													$("#btn-nro").removeClass("btn btn-default active");
													$("#btn-nro").addClass("btn-black");
    										}
											else {
													$("#btn-nro").removeClass("btn-black");
													$("#btn-nro").addClass("btn btn-default active");
											}
										',
										'onclick'=>'$(".modal-body").css("min-height", "50px");setTimeout("document.getElementById(\"facturasform-nrodde\").focus()", 530);',
										
										],
							    	]); 
						    ?>                  
			                
				                <?= $form->field($search, 'nrodde')->label('Desde') ?>
				                <?= $form->field($search, 'nrohta')->label('Hasta') ?>
			
			                <?php 
							    Modal::end();
						    ?>  
						    <br>     
			                <!-- -------------------------  fin NUMEROS ------------------------------------------------ -->
			                
			                
			                <!-- -------------------------  ini MAS FILTOS ------------------------------------------------ -->
			                <div style="text-indent: 165px;">
						    <?php
							    Modal::begin([
			// 					    'size' => "modal-sm",
								    'closeButton' => false,
								    'toggleButton' => [
								    	'id'=>'btn-filtros',
								    	'label' => '<span class="glyphicon glyphicon-plus"></span> Filtros', 
								    	'class'=>'btn btn-default active',
								    	'onfocus'=>'javascript:if(
														((parseInt(document.getElementById("facturasform-notificada").value)+1) +
														(parseInt(document.getElementById("facturasform-impresacli").value)+1) +
														(parseInt(document.getElementById("facturasform-impresa").value)+1) +		
														(document.getElementById("facturasform-puntoventa").value.length)) > 0
														) {
													$("#btn-filtros").removeClass("btn btn-default active");
													$("#btn-filtros").addClass("btn-black");
    										}
											else {
													$("#btn-filtros").removeClass("btn-black");
													$("#btn-filtros").addClass("btn btn-default active");
											}
										',
										'onclick'=>'setTimeout("document.getElementById(\"facturasform-puntoventa\").focus()", 530);',										
										],
							    	]); 
						    ?>  
						    </div>
						    <div style="text-indent: 115px;">
						    
						    <?= $form->field($search, 'puntoventa')->textInput(['style'=>'width:80%;'])?>
			                <?= $form->field($search, 'notificada')->dropDownList(
			                		['-1'=>'todos','0'=>'no','1'=>'si'],
			                		['style'=>'width:80%;']
			                		); 
			                ?>
			                <?= $form->field($search, 'impresacli')->dropDownList(
			                		['-1'=>'todos','0'=>'no impresa','1'=>'impresa'],
			                		['style'=>'width:80%;']
			                		); 
			                ?>
			                <?= $form->field($search, 'impresa')->dropDownList(
			                		['-1'=>'todos','0'=>'no impresa','1'=>'impresa'],
			                		['style'=>'width:80%;']
			                	);
							?>
			               
			                <?php 
							    Modal::end();
						    ?>  
						    </div>
			                <!-- -------------------------  fin MAS FILTOS ------------------------------------------------ -->
			                
			                <div align="right">
			                <br>
			                	<?= Html::button('<span class="glyphicon glyphicon-trash"></span>', [
						                'class' => 'btn btn-danger', 
						                'name' => 'reset-button',
						                'onclick'=>'
												$("#btn-fecha").removeClass("btn-black");
												$("#btn-fecha").addClass("btn btn-default active");	
		
												$("#btn-nro").removeClass("btn-black");
												$("#btn-nro").addClass("btn btn-default active");	

												$("#btn-filtros").removeClass("btn-black");
												$("#btn-filtros").addClass("btn btn-default active");			
				
		
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
			                		'id'=>'btn_reset_compacto', 
			                		'name' => 'reset-button',
			                		'onmousedown'=>'document.getElementById("btn_reset_compacto").click();',
			                		'onclick'=>'
		
		
								javascript:if(
												((parseInt(document.getElementById("facturasform-notificada").value)+1) +
												(parseInt(document.getElementById("facturasform-impresacli").value)+1) +
												(parseInt(document.getElementById("facturasform-impresa").value)+1) +		
												(document.getElementById("facturasform-puntoventa").value.length)) > 0
											) {
												$("#btn-filtros").removeClass("btn btn-default active");
												$("#btn-filtros").addClass("btn-black");
    										}
											else {
													$("#btn-filtros").removeClass("btn-black");
													$("#btn-filtros").addClass("btn btn-default active");
											}
											
											if((document.getElementById("facturasform-fchdde").value + document.getElementById("facturasform-fchhta").value).length > 0) {
													$("#btn-fecha").removeClass("btn btn-default active");
													$("#btn-fecha").addClass("btn-black");
    										}
											else {
													$("#btn-fecha").removeClass("btn-black");													
													$("#btn-fecha").addClass("btn btn-default active");
											}				
		
											if((document.getElementById("facturasform-nrodde").value + document.getElementById("facturasform-nrohta").value).length > 0) {
													$("#btn-nro").removeClass("btn btn-default active");
													$("#btn-nro").addClass("btn-black");
    										}
											else {
													$("#btn-nro").removeClass("btn-black");
													$("#btn-nro").addClass("btn btn-default active");
											}		
		
		
										document.getElementById("facturasform-receptor").focus();
										'
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

			    
<style>
.btn-black {
    color: #fff;
    background-color: #2f2f2f;
    border-color: #000000;
    
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
/*     border: 1px solid transparent; */
    border-radius: 4px;    
}

btn-black:hover {
    color: #f9f9f9;
}
</style>			    