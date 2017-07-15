<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';

// $this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function() {
	document.getElementById("loginform-username").focus();
});
JS;
$this->registerJs($script);

?>

<style>

body {
    background-color: #FAFAFA;
}



#recuadro {
/*  	text-align: center  */
/* 	left: 30%; */
/* 	top: 10%; */
/*   	bottom:40%; */
/* 	width:40%; */
/*  	height:90%;  */
 	display: block;
/* 	position: relative; */
/* 	max-height: 700px; */
/* 	max-width: 700px; */
/*  	min-height: 320px;  */
/*  	min-width: 300px;  */
 	padding: 15px 20px 50px 20px; 
/*  	padding: 20px 25px 50px 25px;  */ 	
/* 	border-image: initial;  */
	border: 1px solid #337ab7;
	background:#ffffff; 
	box-shadow:4px 4px 20px #6B6873;"
}

</style>


<div class="site-login">

    <div class="col-sm-12">
    <br>
    <br>
	</div>
    <div class="col-sm-12">
    
    
    		<div class="col-sm-4">
    		</div>
    		
    		<div class="col-sm-4">
			<div id="recuadro">
		            <?php $form = ActiveForm::begin(['id' => 'login-form', 'method'=>'post',
		                                        'layout'=>'horizontal', 'fieldConfig' => [
					                                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
					                                            /*'labelOptions' => ['class'=>''],*/
					                                            'horizontalCssClasses' => [
					                                                'label' => 'col-sm-12',
					                                                'offset' => 'col-md-offset-0',
					                                                'wrapper' => 'col-sm-12',
					                                                'error' => '',
					                                                'hint' => '',
		                                            ],
		                                        ],
		            		]); 
		            ?>  
		            <br>                                  
		                <?= $form->field($model, 'username', [
		    				'inputOptions' => [
		        					'placeholder' => $model->getAttributeLabel('username'),
		    						],
							])
							->textInput(['maxlength'=>20])
							->label(false);
					?>
		                <?= $form->field($model, 'password', [
		    				'inputOptions' => [
		        					'placeholder' => $model->getAttributeLabel('password'),
		    						],
							])
							->passwordInput(['maxlength'=>20])
							->label(false)
					?>
		                
		
					<div align="right">
		                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
		        	</div>
		        	<br>
		                <?= $form->field($model, 'rememberMe')->checkbox() ?>
		        	<hr>
		
		                <div class="pull-right" style="color:#999;">
		                    <?= Html::a('Olvide mi contraseña', ['site/request-password-reset']) ?>
		                </div>
		        	<?php ActiveForm::end(); ?>
		        </div>

		        </div>
		        
				<div class="col-sm-3">
    			</div>
		        
		        
		</div>
    </div>
<br>
    <br>
    <br>
            
