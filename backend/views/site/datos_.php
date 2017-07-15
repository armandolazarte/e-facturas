<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Mis Datos';
$this->params['breadcrumbs'][] = $this->title;
$listPrestador=ArrayHelper::map($prestadores,'conceptoid','descripcion');
$listResponsable=ArrayHelper::map($responsables,'responsableid','responsable');

?>

    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
		echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
		}
	?>

	<div align="center">
    <h3><?= Html::encode($this->title) ?></h3>
	</div>    
	
	<hr>
    

	
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
            		]) 
            ?>
            
			<div class="col-sm-6">
            
                <?= $form->field($model, 'empresaid')->textInput(['readonly' => true]) ?> 
                <?= $form->field($model, 'cuit')->textInput(['maxlength'=>11]) ?>
                <?= $form->field($model, 'nombre') ?>
                <?= $form->field($model, 'nroiibb') ?>
                <?= $form->field($model, 'inicioact')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) ?>
                <?= $form->field($model, 'calle') ?>
                <?= $form->field($model, 'nro') ?>
                
        	</div>
			<div class="col-sm-6">                
                <?= $form->field($model, 'piso') ?>
                <?= $form->field($model, 'depto') ?>
                <?= $form->field($model, 'cp') ?>
                <?= $form->field($model, 'localidad') ?>
                <?= $form->field($model, 'prestadorid')->dropDownList($listPrestador,[]) ?>
                <?= $form->field($model, 'responsableid')->dropDownList($listResponsable,[]) ?>

			</div>
                
			<div class="col-sm-6">
                <br><br><br><hr>
                
				<?= $form->field($model, 'passwordold')->passwordInput() ?>
                <div align="right">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            	</div>
            </div>
            <?php ActiveForm::end(); ?>

