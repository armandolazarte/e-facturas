<?php 
use yii\helpers\Html;
?>


<div class="col-sm-12" align="center">
    <div style="width:70%;" class="alert alert-danger" role="alert">
	<br>
		<div style="width:100%; margin:auto; text-align: center; font-size:17px">
					<span class='glyphicon glyphicon-remove'></span>
					<?php 
					if ($mensaje) 
						echo Html::encode($mensaje);	
					?>
		</div>
		<br>
	</div>
</div>
