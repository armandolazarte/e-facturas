<?php
use yii\helpers\Html;
use common\models\Formato;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';

// $this->params['breadcrumbs'][] = $this->title;
?>

<style>

body {
    background-color: #FAFAFA;
}



#recuadro {
/*  	text-align: center  */
	left: 30%;
	top: 10%;
/*   	bottom:40%; */
	width:40%;
 	height:90%; 
 	display: block;
	position: relative;
/* 	max-height: 700px; */
/* 	max-width: 700px; */
 	min-height: 320px; 
 	min-width: 300px; 
 	padding: 20px 25px 50px 25px; 
/* 	border-image: initial;  */
	border: 1px solid #337ab7;
	background:#ffffff; 
	box-shadow:4px 4px 20px #6B6873;"
}

</style>


<div class="site-login">
    <h1><?php // Html::encode($this->title) ?></h1>

<!--     <p>Please fill out the following fields to login:</p> -->

    <br>
    <br>
    <br>
    <div class="col-lg-12">
	<div id="recuadro">
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'method'=>'post',
                                        'layout'=>'horizontal', 'fieldConfig' => [
			                                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			                                            /*'labelOptions' => ['class'=>''],*/
			                                            'horizontalCssClasses' => [
			                                                'label' => 'col-lg-12',
			                                                'offset' => 'col-md-offset-0',
			                                                'wrapper' => 'col-lg-12',
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
					->textInput(['maxlength'=>30])
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

                    Si no recuerda su contrase&ntilde;a puede <?= Html::a('Resetearla', ['site/request-password-reset']) ?>.
                </div>
        	<?php ActiveForm::end(); ?>
        </div></div>
    </div>
<br>
    <br>
    <br>
            
