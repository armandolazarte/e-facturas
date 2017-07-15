<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Mis Datos';
$this->params['breadcrumbs'][] = $this->title;
?>


    <!-- <p>Complete los :</p> -->

    <div class="row">

        <div align="center">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <hr>


        <div class="col-sm-2">
        </div>

        <div class="col-sm-8">
            <?php $form = ActiveForm::begin(['id' => 'datos', 'method'=>'post', 
            		'enableClientValidation'=> true, 'enableAjaxValidation'=> false,
            		'layout'=>'horizontal', 'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
//                    'horizontalCssClasses' => [
//                    		'label' => 'col-xs-2',
//                            'offset' => 'col-sm-5',
//                            'wrapper' => 'col-sm-4',
//                            'error' => '',
//                            'hint' => '',
//                            ],
                	    ],
            		]) 
            ?>


                
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'cuit')->textInput(['maxlength'=>11]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'passwordrepeat')->passwordInput() ?>
                <div class="form-group" style="border-top: 2px dashed grey;">
                </div>
                <?= $form->field($model, 'passwordold')->passwordInput() ?>
              	<hr>
                <div align="right">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
