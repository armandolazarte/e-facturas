<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Formato;

/* @var $this yii\web\View */
/* @var $model backend\models\Empresas */

// $this->title = $model->razonsocial;
// $this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

// puntoventa, comprobanteid, notificada, cantidad

$columnas = array();

foreach ($model as $clave => $valor) {
	foreach ($valor as $c => $v) {
		if (!in_array($c, $columnas)) {
			array_push($columnas, $c);
		}		 
	}
}

?>

<div class="col-sm-12">
<div class="col-sm-2">
</div>    
<div class="col-sm-8" align="center">
<br><br>
<h4><?= Html::encode($empresa) ?></h4>
<hr>
</div>



<div class="col-sm-2">
    	<div class="col-sm-12">
    		<input id="fchdde" type="text" class="input-sm form-control" style="text-align: center; background:#f8f8f8; font-size: 14px;" value="<?= Formato::fecha_mes($fechas->fchdde)?>" readonly></input>  
    	</div>    
    	<div class="col-sm-12">
			<input id="fchhta" type="text" class="input-sm form-control" style="text-align: center; background:#fefefe; font-size: 14px;" value="hasta" readonly></input>
    	</div>
    	<div class="col-sm-12">
    		<input id="fchhta" type="text" class="input-sm form-control" style="text-align: center; background:#f8f8f8; font-size: 14px;" value="<?= Formato::fecha_mes($fechas->fchhta)?>" readonly></input>  
	    	<br>
	    </div>
</div>
</div>



<div class="col-sm-2">
</div>
<div class="col-sm-8">
<div class="table-responsive">
<div class="thumbnail_">
<table class='table table-striped table-condensed'>
    <thead>
      <tr>
      <?php
      foreach ($columnas as $column) {
			if (strtolower($column) == 'cantidad'){
				echo "<th style='text-align:right;'>$column</th>";
			}
			else {
				echo "<th style='text-align:center;'>$column</th>";
			}
		}
		?>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach ($model as $row) {
		
		$class = ($row['Notificada'] == 1) ? 'success' : 'danger';
		$class = ($row['Notificada'] === null) ? '' : $class;
		$class = ($row['Punto_Venta'] === null) ? 'colorTotal' : $class;
		echo "<tr class=$class>";
		foreach ($row as $col => $column) {
			if (strtolower($col) == 'notificada'){
				if ($column === null) {
					echo "<td></td>";
				}
				elseif ($column == 1) {
					echo "<td style='text-align:center;'>
							<span class='alert-success'><span class='glyphicon glyphicon-ok'></span></span>
						  </td>";
				}
				else {
					echo "<td style='text-align:center;'>
							<span class='alert-danger'><span class='glyphicon glyphicon-remove'></span></span>
						  </td>";
				}
			}
			elseif (strtolower($col) == 'cantidad') {
				if ($row['Punto_Venta'] === null) {
					echo "<td style='text-align:right; font-weight: bold; font-size: 18px; color:#555;'>$column</td>";
				}
				elseif ($row['Notificada'] === null) {
					echo "<td style='text-align:right; font-weight: bold; color:#777;'>$column</td>";
				}
				else {
					echo "<td style='text-align:right;'>$column</td>";
				}
			}
			elseif (strtolower($col) == 'comprobante') {
				if ($row['Punto_Venta'] === null) {
					echo "<td style='text-align:right; font-weight: bold; font-size: 18px; color:#555;'>TOTAL: </td>";
				}
				else {
					echo "<td style='text-align:center;'>$column</td>";
				}
			}
			else{
				echo "<td style='text-align:center;'>$column</td>";
			}
		}
		echo "</tr>";
	}
    ?>
    </tbody>
</table>
</div>
</div>
</div>
<div class="col-sm-2">
</div>    	        





<style>
.colorTotal {
	background-color: #EEE;
} 
</style>