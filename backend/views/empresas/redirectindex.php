<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
// Large spinner aligned left with inherited color from parent container (inside a div element)
$title = 'Empresas';
$url = 'index';

$script = <<< JS
$(document).ready(function() {

		$("#btn-modal").hide();
		$("#btn-modal").click();

		// se quitan todos los eventos del modal para que no pueda cerrar la ventana
		$("#w0").off();
		
});
JS;
$this->registerJs($script);


$class_alert='info';
?>
<meta http-equiv="refresh" content="0;url=<?= Url::to([$url]) ?>" />


						    
				<?php Modal::begin([
// 					'header' => '',
					'size' => "modal-md",
					'closeButton' => false,
					'toggleButton' => [
							    	'id' => 'btn-modal',
							    	'label' => '<span class="glyphicon glyphicon-calendar"></span> Fechas CAE', 
							    	'class'=>'btn btn-default active',
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
	    				<h4>
							Cargando datos <?=$title?> . . .
	    				</h4>
						<!-- 			fa fa-circle-o-notch	 
										fa fa-cog	
										fa fa-gear	
										fa fa-refresh	
										fa fa-spinner				
						-->				
	    				<i class="fa fa-spinner fa-spin" style="font-size:50px"></i>
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
	
    var modals = document.getElementsByClassName("modal-content");

	for (i = 0; i < modals.length; i++) { 
		modals[i].style.background = $color;
	}

	
}
</script>