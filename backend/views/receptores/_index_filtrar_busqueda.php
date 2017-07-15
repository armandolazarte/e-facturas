<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

?>


    <div style="text-align: left;">
	<?php
	    Modal::begin([
					'header' => '<center><b><span class="glyphicon glyphicon-search"></span> Filtrar Busqueda </b></center>',
// 		    'size' => "modal-lg",
// 		    'closeButton' => false,
		    'toggleButton' => [
		    	'onclick'=>'setTimeout("document.getElementById(\"receptoressearch-nombre\").focus()", 560);',
		    	'label' => '<span class="glyphicon glyphicon-search"></span> Filtrar Busqueda', 
		    	'class'=>'btn btn-success'
	    		],
// 		    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
	    	]); 
    ?>  

    <div class="row">
        <div class="col-sm-10">
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
            ]) ?>
            	<p>
                <?= $form->field($searchModel, 'nombre') ?>
                <?= $form->field($searchModel, 'direccion') ?>
                <?= $form->field($searchModel, 'localidad') ?>
                <?= $form->field($searchModel, 'telefono') ?>
                <?= $form->field($searchModel, 'cuit') ?>
                <?= $form->field($searchModel, 'mail') ?>
                <?= $form->field($searchModel, 'filtro_principal')->hiddenInput()->label(false); ?>
                
                <div class="form-group" align="right">
                			                	<?= Html::button('<span class="glyphicon glyphicon-trash"></span>', [
						                'class' => 'btn btn-danger', 
						                'name' => 'reset-button',
						                'onclick'=>'
												var frm = document.getElementById("form-receptores");
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
		
												document.getElementById("receptoressearch-nombre").focus();
												'
									]) 
								?>
                	<?= Html::resetButton('<span class="glyphicon glyphicon-refresh"></span>', [
                		'class' => 'btn btn-success', 
                		'name' => 'reset-button',
                		'onclick'=>"document.getElementById('receptoressearch-nombre').focus()"
						]
            		)
            		?>
                    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', 
                    ['id' => 'btn_buscar', 'class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php 
	    Modal::end();
    ?>             
	</div>
    <br><br>

