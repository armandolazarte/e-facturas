<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Airtech - Consola factura electronica';

$validator = new yii\validators\UrlValidator();
// list-group-item-
// text-
// alert alert-
// btn-

?>

<div class="row">
    <div class="col-md-3 col-sm-4">
        <div class="panel-title">

        
            <?php foreach ($estados as $punto): ?>
            	
            	<?php $key = ($punto['estado'] == $ESTADO_SI) ? 'success' : 'danger'; ?>
            	<?php $key = ($punto['estado'] == 1) ? 'info' : $key; ?>
            	
            	<?php $icon = ($punto['estado'] == $ESTADO_SI) ? 'ok' : 'remove'; ?>
            	<?php $icon = ($punto['estado'] == 1) ? 'question-sign' : $icon; ?>
            	
				<?php 
				$label = $punto['titulo'];
				$icono = '<span class="glyphicon glyphicon-'. $icon .'"></span>&ensp;';
				$titulo_boton = '<div class="pull-left">'.$icono.$label.'</div>';

				$URL = false;
				if ($validator->validate($punto['vista'])) {
					$URL = true;
				}
				?>             	            	
	            	
				<?php Modal::begin([
					'header' => '<center><b>'. $punto['titulo'] .'</b></center>',
					'size' => "modal-sm",
		    		'toggleButton' => [
		    			'label' => $titulo_boton, 
						'onclick' => 'colorModal("'.$key.'")',
		    			'style' => 'width:230px',
			    		'class'=>'alert alert-'. $key
		    		],
		    		'headerOptions' => [
// 		    				    		'style' => 'background:#000000',
		    				    		'class'=>'alert-'. $key
		    				],		   
					'footer' => ($URL) ? '<a class="btn btn-'. $key .'" href="'. $punto['vista'] .'"  target="_blank">Ver <span class="glyphicon glyphicon-share-alt"></span></a>' 
	            					   : Html::a('Ver <span class="glyphicon glyphicon-share-alt"></span>', [$punto['vista']], ['class' => 'btn btn-'. $key]),
// 					'footerOptions' => [
// 		    				 		'style' => 'background:#000000',
// 		    						'class'=>'alert-'. $key
// 		    				],		    				
			    ]); 
			    ?>  
			    
			    <div class="alert-<?= $key?> fade in">
					<p><?= $punto['descripcion'] ?></p>
				</div>
				<?php Modal::end();?>             
	            	
            
            <?php endforeach; ?>        
        
        </div>
    </div>

    <div class="col-md-9 col-sm-8">
        <div id="titu" class="jumbotron" style="background:#FFFFFF;">
        <h1>Bienvenidos!</h1>

        <p>a la consola de factura electronica donde podra imprimir las facturas y chequear el estado de sus servicios.</p>

    	</div>
    
    
    
    
    
<div>

		<?php foreach ($mensajes_empresa as $mensaje): ?>

		<div class="<?= $mensaje['colorfondo']?>">
<!--         	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
	        <?= '<'. $mensaje['sizetitulo'] .'>' ?>
	        <div class="<?= $mensaje['textalign']?>">
	        <?= $mensaje['titulo']?>        
			<?= '</'. $mensaje['sizetitulo'] .'>' ?>
	        <p class="lead"><?= $mensaje['descripcion']?></p>
			</div>
    
		<?php endforeach; ?>        
            
</div>    
    
</div>
    
    
    
</div>
</div>



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