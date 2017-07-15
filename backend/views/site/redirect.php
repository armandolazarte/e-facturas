<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
// Large spinner aligned left with inherited color from parent container (inside a div element)

/*
 * al cargar la pagina 
 * se esconde el boton modal 
 * se lanza la ventana modal
 * se quitan todos los eventos del modal 
 * */ 
$script = <<< JS
$(document).ready(function() {

		$("#btn-modal").hide();
		$("#btn-modal").click();

		// se quitan todos los eventos del modal para que no pueda cerrar la ventana
		$("#w0").off();
		
});
JS;
$this->registerJs($script);

$view = (!isset($params['view'])) ? 'site/index' : $params['view'];
$title = (!isset($params['title'])) ? '' : $params['title'];
$msg = (!isset($params['msg'])) ? '' : $params['msg'];
$class_alert = (!isset($params['color'])) ? 'info' : $params['color'];
$class_spinner = (!isset($params['spinner'])) ? 'spinner' : $params['spinner'];


?>
<meta http-equiv="refresh" content="1;url=<?= Url::to([$view]) ?>" />


						    
				<?php Modal::begin([
// 					'header' => '',
					'size' => "modal-md",
					'closeButton' => false,
					'toggleButton' => [
							    	'id' => 'btn-modal',
							    	'style' => 'display: none;',
// 							    	'label' => '<span class="glyphicon glyphicon-calendar"></span> Fechas CAE', 
// 							    	'class'=>'btn btn-default active',
							    	'onclick' => 'colorModal("'.$class_alert.'")',
									],
// 		    		'headerOptions' => [
// 									'style' => 'background:#000000',
//									'class'=>'alert-info'
// 		    				],		   
// 					'footer' => '',
// 					'footerOptions' => [
// 									'style' => 'background:#000000',
// 		    						'class'=>'alert-'. $class_alert
// 		    				],		    				
			    ]);

			    ?>  
	    			<div class='<?= 'alert-'. $class_alert?>' align='center'>
	    			<br>	
						<!-- 			
										fa fa-circle-o-notch	 
										fa fa-cog	
										fa fa-gear	
										fa fa-refresh	
										fa fa-spinner				
						-->
	    				<i class="<?= 'fa fa-'. $class_spinner. ' fa-spin'?>" style="font-size:50px"></i>
	    				<br><br>
	    				<div style="font-size:20px">
	    					<?= ucwords($title)?>
	    				</div>
	    				<br>
	    				<div style="font-size:16px">
	    					<?= ucfirst($msg)?>
	    				</div>
	    			</div>
	    			<br>
				<?php Modal::end();?>             


<script>
function colorModal($color) {

	if ($color == 'success')
		$color = '#dff0d8';

	else if ($color == 'danger') 
		$color = '#f2dede';

	else if ($color == 'info') 
		$color = '#d9edf7';

	else if ($color == 'warning') 
		$color = '#fcf8e3';
	
    var modals = document.getElementsByClassName("modal-content");

	for (i = 0; i < modals.length; i++) { 
		modals[i].style.background = $color;
	}

	
}
</script>