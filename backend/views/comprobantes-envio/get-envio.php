<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Formato;
use backend\models\EmpresasAdmin;
/* @var $this yii\web\View */
/* @var $model backend\models\ComprobantesEnvio */

$this->title = 'Detalle Error FE';
// $this->params['breadcrumbs'][] = ['label' => 'Empresas - Errores FE', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

$empresa = (EmpresasAdmin::isAdmin()) ? $model['empresaid'] : '<br>';

?>
<div class="comprobantes-envio-view">

<h3><?= Html::encode($this->title) ?></h3>
	
	<div align="center" style="font-size:24px;color:#999"><?=$empresa?></div>
	
<div align="left">

<button class="btn btn-sm btn-default active_" onclick="botonVerFactura()"> 
<b><span class="glyphicon glyphicon-collapse-down" style="font-size: 15px;"></span>&nbsp;FACTURA ANTERIOR</b>
</button>
<?= 
Html::a('<span class="glyphicon glyphicon-eye-open" style="font-size: 14px; color:#337ab7"></span>',
['facturasenc/view','id' => $facturaEnc_con_cae['facturaid']],
[
'id' => 'btnVer',
'class' => 'btn btn-sm btn-default active_',
'title' => 'Ver',
'style' => 'display:none',
'target'=>'_blank',
'data-pjax' => '0',
])
?>
<br><br>
<div class="collapse" id="collapseExample">

     <div class="col-sm-5">

    <?= DetailView::widget([
        'model' => $facturaEnc_con_cae,
        'attributes' => [
	        [
	        'label' => 'Punto Venta',
	        'value' => $facturaEnc_con_cae['puntoventa_nro'],
	        ],
	        [
	        'label' => 'Comprobante',
	        'value' => $facturaEnc_con_cae['comprobante'],
	        ],
	        [
	        'label' => 'Número',
	        'value' => $facturaEnc_con_cae['comprobantenro'],
	        ],
	        [
	        'label' => '&nbsp;&nbsp;'.'Fecha_Factura',
	        'value' => Formato::fechaHora($facturaEnc_con_cae['fechafactura'])
	        ],
	        [
	        'label' => 'CAE',
	        'value' => $facturaPie_con_cae['cae'],
	        ],	        	        	        	                
        ],
        'options' => ['class' => 'table table-hover table-condensed_ table-striped table-bordered detail-view alert alert-success']
    ]) ?>

    </div>
    <div class="col-sm-7">
    
        <?= DetailView::widget([
        'model' => $facturaEnc_con_cae,
        'attributes' => [
	        [
	        'label' => 'Cliente',
	        'value' => $facturaEnc_con_cae['clienteid'],
	        ],
// 	        [
// 	        'label' => 'cuit',
// 	        'value' => $facturaEnc_con_cae['cuit'],
// 	        'value' => function ($data) {
// 	        	$clienteid = ($data['cuit'] !== null) ? $data['cuit'] : '';
// 	        	return $clienteid;
// 	        	},
// 	        ],
            'cuit',
	        'nombre',
	        [
	        'label' => 'Dirección',
	        'value' => $facturaEnc_con_cae['direccion'],
	        ],
            'localidad',
        ],
        'options' => ['class' => 'table table-hover table-condensed_ table-striped table-bordered detail-view alert alert-success']
    ]) ?>
    </div>
<div style="color:#fff; font-size: 0px;">.</div>
</div>
</div>
	
	
	
	
<div class="collapse" id="collapseError">
     <div class="col-sm-5">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
	        [
	        'label' => 'Punto Venta',
	        'value' => $model['puntoventa_nro'],
	        ],
	        [
	        'label' => 'Comprobante',
	        'value' => $model['comprobante'],
	        ],
	        [
	        'label' => 'Número',
	        'value' => $model['comprobantenro'],
	        ],
	        [
	        'label' => 'Fecha_Factura',
	        'value' => Formato::fechaHora($model['fechafactura'])
	        ],
	        [
	        'label' => 'Fecha_Rechazo',
	        'value' => Formato::fechaHora($model['fecha_rechazo'])
	        ],	        	        	        	                
        ],
        'options' => ['class' => 'table table-hover table-condensed_ table-striped table-bordered detail-view alert alert-danger']
    ]) ?>

    </div>
    <div class="col-sm-7">
    
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
	        [
	        'label' => 'Cliente',
	        'value' => $model['clienteid'],
	        ],
            'cuit',
	        'nombre',
	        [
	        'label' => 'Dirección',
	        'value' => $model['direccion'],
	        ],
            'localidad',
        ],
        'options' => ['class' => 'table table-hover table-condensed_ table-striped table-bordered detail-view alert alert-danger']
    ]) ?>
    </div>
    
	<div class="col-sm-12">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		        [
		        'headerOptions' => ['style' => 'text-align: center'],
		        'contentOptions'=>[ 'style'=>'text-align: left'],
		        'attribute'=>'errores',
		        'format' => "raw",
		        'label' => "Errores",
		        'value' => Formato::erroresCae($model['errores'])
		        ],
        	],
        	'template' => '<tr><th>{label}</th><td>{value}</td></tr>',
        	'options' => ['class' => 'table table-hover table-condensed_ table-striped table-bordered detail-view alert alert-danger']
    	]) 
    	?>
    </div>
	<div class="col-sm-12">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
            'headerOptions' => ['style' => 'text-align: center'],
            'contentOptions'=>[ 'style'=>'text-align: left'],
            'attribute'=>'observaciones',
            'format' => "raw",
            'label' => "Observaciones",
            'value' => Formato::erroresCae($model['observaciones'])
            ],
            
        	],
        	
        	'options' => ['class' => 'table table-hover table-condensed_ table-striped table-bordered detail-view alert alert-info']
    	]) 
    	?>
    </div>
    
    
</div>
</div>




<style>

table.detail-view th {
		text-align: right;
        width: 15%;
}

table.detail-view td {
        width: 85%;
}    	

    	
</style>


<?php
$script = <<< JS

$(document).ready(function() {
    $('#collapseError').toggle(300);
});    	

JS;
$this->registerJs($script);
?>

<script>

var facturaid_js =  "<?= $facturaEnc_con_cae['facturaid']?>";

function botonVerFactura() {

if(facturaid_js != 0) {

	if ($('#btnVer').is(':visible') === true) {
		$('#btnVer').toggle(300);
	} else {
		$('#btnVer').toggle(300);

	}
}

$('#collapseExample').toggle(300);
}
</script>
