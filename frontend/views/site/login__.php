<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?php // Html::encode($this->title) ?></h1>

<!--     <p>Please fill out the following fields to login:</p> -->

        <div class="row">
        <div class="col-sm-8">
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'method'=>'post',
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
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                
                <div class="pull-right" style="color:#999;">
                    Si no recuerda su contraseña puede <?= Html::a('resetearla', ['site/request-password-reset']) ?>.
                </div>
            <br><hr>
            <div class="pull-right">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        	</div>
            <?php ActiveForm::end(); ?>
        </div></div>
    </div>
</div>
