<?php
use yii\helpers\Html;

$mail_class = ($action == 'mail') ? 'list-group-item active' : 'list-group-item' ;
$password_class = ($action == 'password') ? 'list-group-item active' : 'list-group-item' ;
$descripcion_class = ($action == 'descripcion') ? 'list-group-item active' : 'list-group-item' ;

?>


<div class="col-md-3 col-sm-4">
	<div class="list-group">


		<?php
		$label = '<div class="pull-left">'.'Email'.'</div>'.
		'<div class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></div><br/>'
		?>
		<?= Html::a($label, ['email'], ['class' => $mail_class]);?>
        
				
		<?php 
		$label = '<div class="pull-left">'.'Password'.'</div>'.
		'<div class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></div><br/>'
		?>        
		<?= Html::a($label, ['password'], ['class' => $password_class]);?>

		<?php 
		$label = '<div class="pull-left">'.'Descripción'.'</div>'.
		'<div class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></div><br/>'
		?>        
		<?= Html::a($label, ['consola-descripcion'], ['class' => $descripcion_class]);?>
		
		
		<br/>
		
	</div>
</div>
