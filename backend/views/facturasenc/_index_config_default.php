<?php 
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$check_config_msg_HTML = '<input type="checkbox" id="check_config_msg" checked style="transform: scale(1.2);">';
$check_config_msg_HTML = ($CONFIG_msg_notif) ? $check_config_msg_HTML : '<input type="checkbox" id="check_config_msg" style="transform: scale(1.2);">';

$color_boton_tag = ($CONFIG_msg_notif) ? 'color:#337ab7' : '';

?>



<div align="right">


<?php 


Modal::begin([
// 'header' => '<center><b style="color:#337ab7"> mensaje</b></center>',
// 'size' => "modal-sm",
'closeButton' => false,
'toggleButton' => [
		'id' => 'btn_check_config_msg',
		'label' => '<span class="glyphicon glyphicon-tags"></span> ',
		'style' => 'display_:none;' . $color_boton_tag,
		'class' => 'btn btn-md btn-default active',
		'title' => 'Configuración Mensaje Adicional',
		],
]); 
?>  

<div class="col-sm-12">

<div class="col-sm-1">
<?=			
Html::a('<span class="glyphicon glyphicon-picture" style= "color:#555; font-size:14px"></span>',
'#',
[
'id' => 'btn_vista_notif',
'class' => 'btn btn-xs btn-default active',
'data-toggle' => 'tooltip',
'data-placement' => 'bottom',
'title' => 'Vista ejemplo',
'onclick' => "$('#vista_notif_config').toggle(300);",
'style' => 'padding:4px 8px; margin-left:-30px; color:#555',
]);
?>		    		
</div>


	<div class="col-sm-18" >
		<div class="col-sm-10" style="top:4px">
			<div style="font-size: 17px" >Permitir envío de mensaje adicional al notificar factura</div>
		</div>
		<div class="col-sm-1" style="top:6px">
		<?= $check_config_msg_HTML?>
		</div>
	</div>
</div>

<br>

<div id="vista_notif_config"  style="text-align:center; display:none">
	<br><br>
	<img src="<?= $logoURL?>" width="185px" height="95px" />
	<br><br>
	<img src="<?= Url::base('http') . '/images/notificacion.png'?>" width="453px" height="272px"/>
</div>


<?php Modal::end();?> 


<button class="btn btn-default active " title="Configuración Filtros Mis Facturas" data-toggle="collapse"
data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
<span class="glyphicon glyphicon-cog"></span>
</button>
<!-- <br><br> -->
<div class="collapse" id="collapseExample">
<div class="alert_copy alert-info">
<div align="left">
Configure los filtros por defecto para visualizar las facturas.
Estos se aplicaran cada vez que seleccione <b>Mis Facturas</b>
<br>
Luego podrá refinar la búsqueda desde <b>Filtrar Búsqueda</b>
<br><p>
</div>
<div align="right">
<?= Html::a('<span class="glyphicon glyphicon-cog"></span> Configurar',
		['configfactindex/update'],
		[
				'class' => 'btn btn-info btn-md',
				//             				'name' => 'notificar-button',
		//             				'title' => 'Configuración Filtros Mis Facturas',
		//                     		'target'=>'_blank'
		]
)
?>

        </div>
  
  
  </div>
</div>
</div>

<style>
.alert_copy {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
</style>