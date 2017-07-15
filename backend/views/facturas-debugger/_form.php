<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FacturasDebugger */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturas-debugger-form">

<div class="col-sm-5">
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
            		]); 
            ?>  

    <br><br>
    <?= $form->field($model, 'facturaid')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'height_barcode')->textInput() ?>

    <?= $form->field($model, 'width_barcode')->textInput() ?>

    <?= $form->field($model, 'font_barcode')->textInput() ?>

    <?= $form->field($model, 'status')->inline(true)->radioList(array(1=>'Si', 0=>'No')) ?>

    <div align="right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="col-sm-2">
<br><br>
<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
	echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>
</div>
</div>


<?php 
$script = <<< JS

		
		
window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
    });
}, 500);


JS;
$this->registerJs($script);
?>
