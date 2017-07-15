<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Resetear password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h3><?= Html::encode($this->title) ?></h3>

        <div class="row">

        <div class="col-sm-8">
                <p>Ingrese su nueva password:</p>
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'method'=>'post',
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
                <br/>

                <?= $form->field($model, 'password')->passwordInput() ?>
                
                <div class="pull-right">
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                </div>
                </div>
        </div>
    </div>
</div>