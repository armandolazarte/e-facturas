<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FacturasMensajesNotificacion */

$this->title = 'Mensaje Notificación Factura';//$model->facturaid;
// $this->params['breadcrumbs'][] = ['label' => 'Facturas Mensajes Notificacions', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturas-mensajes-notificacion-view">

<br><br>
    <p style="text-align:center; color:#777; font-size:23px">
    	<?= Html::encode($this->title) ?>
    </p>

    <p>
        <?php 
// Html::a('Delete', ['delete', 'id' => $model->facturaid], [
//             'class' => 'btn btn-danger',
//             'data' => [
//                 'confirm' => 'Are you sure you want to delete this item?',
//                 'method' => 'post',
//             ],
//         ]) 
?>
    </p>

<br>
<div class="col-sm-1">        
</div>
<div class="col-sm-10">
<table class="table table-striped table-condensed_ table-bordered">
    <thead>
      <tr>
      	<th style="text-align:center; width:70px; color:#777">PV</th>
      	<th style="text-align:center; width:70px; color:#777">Cpte</th>
      	<th style="text-align:center; width:70px; color:#777">Número</th>
      	<th style="text-align:center; color:#777">Mensaje</th>      
      </tr>
    </thead>
    <tbody>
      <tr class="success">
      	<td style="text-align:center;"><?= $puntoventa ?></td>
      	<td style="text-align:center;"><?= $comprobante ?></td>
      	<td style="text-align:center;"><?= $numero ?></td>
      	<td style="text-align:left;"><?= $mensaje ?></td>
      </tr>
	</tbody>
</table>
</div>    
</div>
