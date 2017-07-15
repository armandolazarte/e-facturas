<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Resetear Contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>




<div class="site-reset-password">
    <h3><?= Html::encode($this->title) ?></h3>

<?php if($ALERT = Yii::$app->session->getAllFlashes()): ?>
    
<?php foreach ($ALERT as $key => $message) {
	echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>    

<nav>
  <ul class="pager">
    <li>
    	<a href="<?= Url::to(['login'], true); ?>">
	    <b>Iniciar Sesión</b>
      	</a>
    </li>
  </ul>
</nav>

<?php else: ?>
    
    <div class="row">
        <div class="col-sm-8">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form',
        		'method'=>'post',
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
			]); 
		?>  
			<div class="col-lg-8">
		    Ingrese su Nueva Contraseña:
            <hr>                                                      
            
            <?= $form->field($model, 'password')->passwordInput()->label('Nueva Contraseña') ?>
            <hr>     
            <div class="pull-right">     
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div></div>
    </div>
    <?php endif;?>
</div>
