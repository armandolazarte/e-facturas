<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

?>
        
<div class="config-periodo-errores-fe-form">       
        
	<?php $form = ActiveForm::begin();?>  


		    <div class="col-sm-2">
            </div>	
	
		    <div class="col-sm-9">
    			<?= $form->field($model, 'periodo')->inline(false)->radioList($model::$periodos)->label(false); ?>
            </div>
    
		    <div align="right">
		        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-sm btn-success' : 'btn btn-sm btn-primary']) ?>
            </div>

    <?php ActiveForm::end(); ?>

</div>
