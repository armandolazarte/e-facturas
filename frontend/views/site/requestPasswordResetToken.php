<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Recuperar password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">


<?php if($ALERT = Yii::$app->session->getAllFlashes()): ?>
    
<?php foreach ($ALERT as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>

<?php else: ?>   


        <div class="row">
        <div class="col-sm-2">
        </div>                


        <div class="col-sm-7">

            <br><br>
            <div class="well">
            <h3><?= Html::encode($this->title) ?></h3>

            <p>Ingrese el email con el cual se registr&oacute;. Se enviar&aacute; un link para modificar su password.</p>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'method'=>'post',
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
            
                <br/>
                <?= $form->field($model, 'email') ?>

                <div align="right">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
                </div>

            
            </div>
        </div>
    </div>
</div>

<?php endif;?>