<?php

use yii\helpers\Html;
use common\models\Email;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturas';
// $this->params['breadcrumbs'][] = $this->title;


$notificadasString = ($masiva[1] == 1) ? 'NOTIFICADA DE' : 'NOTIFICADAS DE' ; 

?>


<?php if ($masiva): ?>

<ul class="nav nav-pills" role="tablist">
  <li role="presentation" class="active">
  <a href="#">
  <span class="badge"><?= $masiva[1]?></span>
  		<?= $notificadasString?>
  <span class="badge"><?= $masiva[2] ?></span>
  </a>
  </li>
</ul>


<br>

<?php 
/*
 * $DETALLE = $ARRAY_FACTURAS_INFO
 * [true, 'NOTIFICADA', $COMPROBANTE, $factura->comprobantenro, $factura->clienteid, $nombre] 
 */
?>
	<?php foreach ($masiva[0] as $DETALLE): ?>
		<?php $notificada = (array_shift($DETALLE)) ?>
		<?php $alerta = ($notificada) ? 'success' : 'danger' ?>
		<?php $check = ($notificada) ? 'ok' : 'remove' ?>
		<div class="alert alert-<?= $alerta?>" role="alert">
			<div style="margin:auto; text-align: left;">
			<?php 
				$contador = 0;
				foreach ($DETALLE as $INFO) {
					if ($contador%2==0) {
						if ($contador==0)
							echo "<big><span class='glyphicon glyphicon-$check'></span><b> $INFO</b></big>";
						else 
							echo " - <b> $INFO </b>";
					}
					else {
						echo " - $INFO";;
					}

					$contador++;
				}
			?>
			</div>
		</div>
	<?php endforeach; ?>

<?php else: ?>

<?php if ($ENVIADO): ?>
	<div class="alert alert-success" role="alert">
	<br>
		<div style="text-align: center;">
		    <h4>Notificación enviada con éxito</h4>
		</div>
	</div>

<?php else: ?>
	<div class="alert alert-danger" role="alert">
	<br>
		<div style="text-align: center;">
		    <h4>NOTIFICACION CANCELADA... El cliente no posee email</h4>
		</div>
	</div>

<?php endif; ?>


<div class="panel panel-default">

<div class="alert alert-info" role="alert">
	<br>
	<div style="width:90%; margin:auto; text-align: left;">
	    Comprobante: <b><?= $COMPROBANTE?></b><br>
	    Número: <b><?= $factura->comprobantenro?></b><br>
	    Cliente: <b><?= $factura->clienteid?></b><br>
	    Nombre: <b><?= $nombre?></b><br>
	    Email Principal: <b><?= $email?></b><br>
		<?php
		if ($arrayMails !== null) {
			
			$c = 0;
			foreach ($arrayMails as $email_a) {
			 	if ($c == 0) {
			 		echo 'Emails: <b>' . $email_a . '</b><br>';
			 	}
			 	else {
					echo '&emsp;&emsp;&emsp;&nbsp; <b>' . $email_a . '</b><br>';
			 	}
			 	$c++;
			}
		}
		
		?>
		<br>
	</div>
	<br>
</div>       
<?php endif; ?>

<nav>
  <ul class="pager">
    <li>
    	<a href="javascript:window.close();">
	    Cerrar Pestaña
      	</a>
    </li>
  </ul>
</nav>

</div>

