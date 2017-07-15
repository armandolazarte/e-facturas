<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EstadosConfiguracionFe */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
        <div class="col-md-8">
        <div class="well" style="background:#fcfcfc;">
            <?php $form = ActiveForm::begin(['id' => 'form-facturas', 'method'=>'post',
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
            ]) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 15]) ?>

    <?= $form->field($model, 'vista')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'activo')->inline(true)->radioList(array(1=>'Si', 0=>'No')); ?>    

    <div align="right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
    </div>  
    </div>  
</div>
    </div>
    