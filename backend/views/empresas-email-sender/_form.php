<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmpresasEmailSender */
/* @var $form yii\widgets\ActiveForm */
?>


<?= $this->render('_info', ['view' => False]) ?>
	
		
            <?php $form = ActiveForm::begin(['method'=>'post',
                                        'layout'=>'horizontal', 'fieldConfig' => [
			                                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			                                            /*'labelOptions' => ['class'=>''],*/
			                                            'horizontalCssClasses' => [
			                                                'label' => 'col-sm-4',
// 			                                                'offset' => 'col-sm-offset-12',
			                                                'wrapper' => 'col-sm-8',
			                                                'error' => '',
			                                                'hint' => '',
                                            ],
                                        ],
            		]); 
            ?>  

<div class="col-sm-1">
</div>        
<div class="col-sm-10">            
            
<div class="col-sm-18  breadcrumb_">
	<div class="col-sm-1">
	</div>        
	<div class="col-sm-11">
	<?= $form->field($model, 'nombre', [
        'template' => '
			<div class="col-sm-1" style="margin-top: 5px;">
        	<b>Nombre</b>&nbsp;&nbsp;
			</div> 
			<div class="col-sm-10">
			{input}{error}{hint}
			</div>',
    ])->textInput(['maxlength' => 100]) ?>
	</div>

</div>
<div class="col-sm-6">
	<div class="col-sm-18">
	    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>
	</div>
    <div class="col-sm-18">
		<?= $form->field($model, 'password')->passwordInput(['maxlength' => 50, 'style'=>'width:70%;']) ?>
    </div>
</div>

<div class="col-sm-6">
	<div class="col-sm-18">
		<?= $form->field($model, 'servidor_smpt')->textInput(['maxlength' => 50, 'style'=>'width:75%;', 'readonly' => true]) ?>            
	</div>
    <div class="col-sm-18">
	    <?= $form->field($model, 'puerto_smpt')->textInput(['maxlength' => 5, 'style'=>'width:25%;', 'readonly' => true]) ?>            
    </div>
</div>

	<div class="col-sm-12 thumbnail alert-warning" align="center">


<strong>ATENCI&Oacute;N:</strong> Tenga en cuenta que antes de configurar este servicio deber&aacute; permitir la notificaci&oacute;n desde esta aplicaci&oacute;n. <br>
Active la opci&oacute;n desde el siguiente link <a href='https://www.google.com/settings/security/lesssecureapps' target='_blank'>https://www.google.com/settings/security/lesssecureapps</a>

		</div>

</div>



<div class="col-sm-1">
</div>

<div class="col-sm-12">
	<hr>
	<div class="col-sm-3">
    </div>
	<div class="col-sm-5">
    	<?= $form->field($model, 'passwordold')->passwordInput() ?>
    </div>    
	<div class="col-sm-1" align="right">
		<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<br><br>
    </div>    
</div>	

<div class="col-sm-12">
		<div class="col-sm-3">
    </div>    

	<div class="col-sm-7" align="center">

		<div class="col-sm-11">
		    <i><small style="color:gray;">* Luego de modificar los datos deber&aacute; validar el email desde su casilla de correo.</small></i>
	    </div>
    </div>    
	<div class="col-sm-2">
    </div>    
</div>	


	<br>

    <?php ActiveForm::end(); ?>
	<br><br>
