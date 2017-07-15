<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
	echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>

<div class="site-signup">

	<div class="row">
	<div class="container">
	<div class="col-xs-12 col-md-12">
	<div class="well pull-right">
	<div class="panel-body">
	
	<h3><?= Html::encode('Crear una cuenta') ?></h3>
	<hr>
            <?php $form = ActiveForm::begin([
            		'id' => 'form-signup', 
            		'enableClientValidation'=> true, 
            		'enableAjaxValidation'=> false,
            		'method'=>'post',
            		'layout'=>'horizontal', 
            		'fieldConfig' => [
            				'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			                 /*'labelOptions' => ['class'=>''],*/
            				'horizontalCssClasses' => [
            						'label' => 'col-xs-12 col-md-12',
            						'offset' => 'col-xs-12 col-md-12',
            						'wrapper' => 'col-xs-12 col-md-12',
            						'error' => '',
            						'hint' => '',
            				],
            		],
            ]); 
            ?>  
                <?= $form->field($model, 'username', [
    				'inputOptions' => [
        					'placeholder' => $model->getAttributeLabel('username'),
    						],
					])
					->textInput(['maxlength'=>30])
					->label(false)
				?>
                <?= $form->field($model, 'email', [
    				'inputOptions' => [
        					'placeholder' => $model->getAttributeLabel('email'),
    						],
					])
					->textInput(['maxlength'=>60])
					->label(false)
				?>
				
                <?= $form->field($model, 'cuit', [
    				'inputOptions' => [
        					'placeholder' => $model->getAttributeLabel('cuit'),
    						],
					])
					->textInput(['maxlength'=>11])
					->label(false)
				?>
				
                <?= $form->field($model, 'password', [
    				'inputOptions' => [
        					'placeholder' => $model->getAttributeLabel('password'),
    						],
					])
					->passwordInput(['maxlength'=>20])
					->label(false)
				?>
				
                <?= $form->field($model, 'passwordrepeat', [
    				'inputOptions' => [
        					'placeholder' => $model->getAttributeLabel('passwordrepeat'),
    						],
					])
					->passwordInput(['maxlength'=>20])
					->label(false)
				?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-md-8">{input}</div></div>',
                
                		
                ]) ?>
           	<hr>
			<div class="pull-right">
                    <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
    </div>
</div>
</div>
