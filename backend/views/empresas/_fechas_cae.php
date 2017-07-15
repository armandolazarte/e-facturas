<?php
use yii\helpers\Html;
use common\models\Formato;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
<div class="col-sm-12">
    <div class="col-sm-4" align="center">
		<br>
    	<div class="col-sm-5">
    		<input id="fchdde" type="text" class="form-control" value="<?= Formato::fecha($fechas->fchdde)?>" readonly></input>  
    	</div>    
    	<div class="col-sm-2" style="margin-left: -15px;">
    		<h4>hasta</h4>  
    	</div>        	
    	<div class="col-sm-5">
    	<input id="fchhta" type="text" class="form-control" value="<?= Formato::fecha($fechas->fchhta)?>" readonly></input>  

<?= Html::button('Create Branches', ['value'=>Url::to('index.php?r=configempresasindex/update'),'class' => 'btn btn-success','id'=>'modalButton']) ?>

    	</div>
    	<br>    	
    </div>    
</div>





    <?php
        Modal::begin([
                'header'=>'<div align="center"><h4>Fechas Facturas CAE </h4></div>',
                'id' => 'modal',
                'size'=>'modal-sm',
            ]);
     
        echo "<div id='modalContent'></div>";
     
        Modal::end();
    ?>
