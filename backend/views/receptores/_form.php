<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use unclead\widgets\MultipleInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Receptores */
/* @var $form yii\widgets\ActiveForm */
?>

<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
	echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>

<div class="receptores-form">

        <div class="row">
        <div class="col-sm-8">
            <?php $form = ActiveForm::begin(['id' => 'form-receptores', 'method'=>'post',
//             		'enableAjaxValidation'      => true,
            		'enableClientValidation'    => false,
            		'validateOnChange'          => false,
            		'validateOnSubmit'          => true,
            		'validateOnBlur'            => false,
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

    <?= $form->field($model, 'cuit')->textInput(['maxlength' => 13]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'localidad')->textInput(['maxlength' => 255]) ?>

    
    <?= $form->field($model, 'telefono')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'mail')->textInput(['maxlength' => 255]) ?>
    
	<?= $form->field($model, 'emails')->widget(MultipleInput::className(), [
        'limit'             => 20,
		'addButtonOptions' => [
				'class' => 'alert-success',
				'label' => '<span class="glyphicon glyphicon-plus"></span>' // also you can use html code
		],
		'removeButtonOptions' => [
				'class' => 'alert-danger',
				'label' => '<span class="glyphicon glyphicon-remove"></span>'
// 				'label' => '<span class="glyphicon glyphicon-trash"></span>'
		],
//         'allowEmptyList'    => false,
//         'enableGuessTitle'  => true,
        'min'               => 1, // should be at least 2 rows
// 	        'addButtonPosition' => MultipleInput::POS_HEADER // show add button in the header
    	])
	//     ->label(false);
	?>			    

    <div align="right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <br>
    <?php ActiveForm::end(); ?>

</div>
</div>

</div>