<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Mi Password';
// $this->params['breadcrumbs'][] = $this->title;

?>

<br/>
<div class="row">

	<?= $this->render('_menu', ['action'=>'descripcion']); ?>
	
	<div class="col-md-9 col-md-8">

	<?= $this->render('_message'); ?>

	
    <div class="col-md-9 col-md-9">
    
    <div class="row">
        <div class="well" style="background:#FCFCFC;">
            <?php $form = ActiveForm::begin(['method'=>'post',
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

                <br><br><br>
                <?=$form->field($model, 'descripcion')->textInput(['readonly' => true]) ?> 
                <?=$form->field($model, 'descripcion_nueva')?>
				<hr>
                <?= $form->field($model, 'passwordold')->passwordInput() ?>
                <hr>
                <div align="right">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => 'btn btn-success', 'name' => 'update-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>    
</div>    


