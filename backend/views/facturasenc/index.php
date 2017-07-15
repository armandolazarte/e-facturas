<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Formato;

$logoURL = Url::base('http') . '/uploads/' . Yii::$app->user->identity->empresaid . '.jpg';// . '_modelo_3.jpg';

$CONFIG_msg_notif = $CONFIG_notificacion_factura->permite_msg_adicional;
$CONFIG_msg_notif_alert_visto = $CONFIG_notificacion_factura->alert_actualizacion_visto;
$CONFIG_msg_replyto_alert_visto = $CONFIG_notificacion_factura->alert_replyto_visto;

$this->title = 'Mis Facturas';
// $this->params['breadcrumbs'][] = $this->title;

$listComprobantes=ArrayHelper::map($comprobantes,'comprobanteid','descripcion');
$listComprobantes[0]='TODOS';

$CONFIG_notificada_status = $CONFIG->notificada_color_status;


$SerialColumn = [
		'class' => 'yii\grid\SerialColumn', 
		'contentOptions'=>['style' => 'text-align: right'],
		'headerOptions' => ['style' => 'text-align: center'],
		'header' => utf8_decode('Nº'),
		
];

$clienteid = [
		'headerOptions' => ['style' => 'text-align: center'],
	'contentOptions'=>['style' => 'text-align: right'],
	'attribute' => 'Cliente',
	'value' => 'clienteid',
];

$nombre = [
				'attribute' => 'Nombre',
				'value' => function ($data) {
					return utf8_decode($data->nombre);
				},		
];

$direccion = [
				'attribute' => 'Direccion',
				'label' => utf8_decode("Dirección"),
				'value' => function ($data) {
					return utf8_decode($data->direccion);
				},	
];

$fechafactura = [
				'headerOptions' => ['style' => 'text-align: center'],
				'contentOptions'=>['width' => '40', 'style' => 'text-align: center'],
				'attribute' => 'Fecha',
				'value' => function ($data) {
					return Formato::fecha($data->fechafactura);
				},
];

$puntoventa = [
				'headerOptions' => ['style' => 'text-align: center'],
				'contentOptions'=>['width' => '40'],
				'attribute' => 'Punto Venta',
				'label' => "PV",
				'value' => function ($data) {
					return $data->puntoventa0->puntoventa;
				},
];



$comprobante = [
            	'headerOptions' => ['style' => 'text-align: center'],
				'attribute' => 'Comprobante',
				'label' => "Cpte",
				'contentOptions'=>['style' => 'text-align: center'],            		
             	'value' => function ($data) {
                	    return Formato::comprobanteAbreviar($data->comprobante->descripcion);
                	},
             	];

$numero = [
				'headerOptions' => ['style' => 'text-align: center'],
				'attribute' => 'Numero',
				'contentOptions'=>['style' => 'text-align: center'],
				'label' => utf8_decode('Número'),
				'value' => 'comprobantenro',
];


$importe = [
            	'headerOptions' => ['style' => 'text-align: center'],
            	'attribute' => 'Importe',
            	'format' => 'raw',
            	'contentOptions'=>['width' => '100', 'style' => 'text-align: right'],
             	'value' => function ($data) {
                	    return "$ ".number_format($data->facturaspies[0]->importetotal, 2, ',', '.');
                	},
			];


$CheckboxColumn = ['class' => 'yii\grid\CheckboxColumn'];

$mensajeid = [
				'headerOptions' => ['width' => '30', 'style' => 'text-align: center'],
            	'attribute' => 'mensajeid',
				'label' => '',
				'format' => 'raw',
				'headerOptions' => ['style' => 'text-align: center'],
				'header' => "<span class='glyphicon glyphicon-tags' style='color:#337ab7'></span>",
				'visible' => ($CONFIG_msg_notif == true) ? true : false,
				'contentOptions'=>['width' => '30', 'style' => 'text-align: right'],
             	'value' => function ($data) {
             			if (isset($data->facturasmensajesnotificacion[0])) {

             				return Html::a('<span class="glyphicon glyphicon-tags"></span>',
             						['facturas-mensajes-notificacion/view',  
             										'pv' => $data->puntoventa0->puntoventa,
             										'c' => Formato::comprobanteAbreviar($data->comprobante->descripcion),
             										'n' => $data->comprobantenro,
             										'id' => $data->facturaid
             								
             						],
             						[
             								'title' => 'Ver',
             								'target'=>'_blank',
             								'data-pjax' => '0',
             						]
             				);             				
             				
             			}
             			return '';
                	},
			];

$notificar_con_mensaje = [
		'headerOptions' => ['style' => 'text-align: center'],
		'label' => '',
		'format' => 'raw',
		'headerOptions' => ['style' => 'text-align: center'],
		'visible' => ($CONFIG_msg_notif == true) ? true : false,
		'contentOptions'=>['width' => '30', 'style' => 'text-align: center'],
		'value' => function ($data) {
			return Html::a('<span class="glyphicon glyphicon-envelope"></span>',
					'#',
					[
						'title' => 'Notificar',
						'onclick' => 'notificar_modal("'.$data->facturaid.'")',
					]
				);					
			}
		];

 $notificar = [
		'headerOptions' => ['style' => 'text-align: center'],
		'label' => '',
		'format' => 'raw',
		'headerOptions' => ['style' => 'text-align: center'],
		'visible' => ($CONFIG_msg_notif == true) ? false: true,
		'contentOptions'=>['width' => '30', 'style' => 'text-align: center'],
		'value' => function ($data) {
			return Html::a('<span class="glyphicon glyphicon-envelope"></span>',
					['notificar','id' => $data->facturaid],
					[
							'title' => 'Notificar',
							'target'=>'_blank',
							'data-pjax' => '0',
							'onclick' => 'uncheckSelection();',
					]
			);
		},
		];

$ver = [
		'headerOptions' => ['style' => 'text-align: center'],
		'label' => '',
		'format' => 'raw',
		'headerOptions' => ['style' => 'text-align: center'],
		'contentOptions'=>['width' => '30', 'style' => 'text-align: center'],
		'value' => function ($data) {
					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
							['view','id' => $data->facturaid],
							[
									'title' => 'Ver',
									'target'=>'_blank',
									'data-pjax' => '0',
							]
					);
				},
		];

$array_check = [
				'attribute' => 'Imp',
				'format' => 'raw',
				'label' => '',
				'headerOptions' => ['style' => 'text-align: center'],
// 				'header' => "<span class='glyphicon glyphicon-print' style='color:#337ab7'></span>",
				'contentOptions'=>[ 'width' => '30', 'style' => 'text-align: center'],
				'visible' => ($CONFIG->mostrar_impresas == 1) ? true : false,
				'value' => function ($data) {
						return $data->impresaproveedor == 1 ? "<span class='glyphicon glyphicon-ok color-si'></span>" : "";
						// 				"<span class='glyphicon glyphicon-remove color-no'></span>";
				},
		];

$impresa_cliente = [
		'attribute' => 'Imp',
		'format' => 'raw',
		'label' => '',
		'headerOptions' => ['style' => 'text-align: center'],
		// 				'header' => "<span class='glyphicon glyphicon-print' style='color:#337ab7'></span>",
		//'contentOptions'=>[ 'width' => '30', 'style' => 'text-align: center', 'data-toggle' => 'tooltip_','title' => 'Vista ejemplo','data-placement' => 'bottom'],
		'visible' => ($CONFIG->impresa_receptor == 1) ? true : false,
		'contentOptions' => function ($data) {
			return $data->impresacliente == 1 
			? [ 'width' => '30', 'style' => 'text-align: center', 'title' => 'Impresa por el receptor']
			: [ 'width' => '30', 'style' => 'text-align: center']
			;
		},
		'value' => function ($data) {
			return $data->impresacliente == 1 ? "<span class='glyphicon glyphicon-user color-receptor-si'></span>" : "";
			// 				"<span class='glyphicon glyphicon-remove color-no'></span>";
		},
		];


// $ActionColumn = ['class' => 'yii\grid\ActionColumn',
// 		'template' => '{ver} &nbsp; {notificar} &nbsp; {mensaje}',
// 		'headerOptions' => ['width' => '90'],
// 		'buttons' => [
// 				'ver' => function ($action, $model, $key) {
// 					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
// 							['view','id' => $model->facturaid],
// 							[
// 									'title' => 'Ver',
// 									'target'=>'_blank',
// 									'data-pjax' => '0',
// 							]
// 					);
// 				},
// 				'notificar' => function ($action, $model, $key) {
// 					return Html::a('<span class="glyphicon glyphicon-envelope"></span>',
// 							['notificar','id' => $model->facturaid],
// 							[
// 									'title' => 'Notificar',
// 									'target'=>'_blank',
// 									'data-pjax' => '0',
// 									'data' => [
// 											'confirm' => 'Are you sure you want to delete this item?',
// 											'method' => 'post',
// 									],									
// 							]
// 					);
// 				},
// 				'mensaje' => function ($action, $model, $key) {
// 					return Html::a('<span class="glyphicon glyphicon-list"></span>',
// 							'#',
// 							[
// 									'title' => 'Ver',
// 									'onclick' => 'notificar_modal("'.$model->facturaid.'")',
// 							]
// 					);					
// 				}
// 		],
// 		];


$columns = [
		$SerialColumn,
		$clienteid,
		$nombre,        		
		$direccion,
		$fechafactura,
		$puntoventa,
		$comprobante,
		$numero,
		$importe,
		$CheckboxColumn,
		$mensajeid,
		$array_check,
		$impresa_cliente,
		$ver,
		$notificar,
		$notificar_con_mensaje,
// 		$ActionColumn,
];



?>

<?php 


Modal::begin([
// 'header' => '<center><b style="color:#337ab7"> mensaje</b></center>',
// 'size' => "modal-lg",
'id' => 'modal_msg',
'closeButton' => false,
'toggleButton' => [
		'id' => 'btn_modal_mensaje',
		'label' => '',
		'style' => 'display:none'
// 		'class'=>'alert alert-success_'
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
'onclick' => 'verVistaPrevia()',
'style' => 'padding:4px 8px; margin-left:-30px; color:#555',
]);
?>		    		
</div>



<div class="col-sm-10">
</div>
<div class="col-sm-1">
<?=			
Html::a('<span class="glyphicon glyphicon-remove"></span>',
'#',
[
'id' => 'btn_notificar_mensaje_modal_cancelar',
'class' => 'btn btn-xs btn-default active',
'data-toggle' => 'tooltip',
'data-placement' => 'bottom',
'title' => 'Cancelar Notificación',
'onclick' => '$("#btn_cerrar_modal").click(); keyup_text();$("#textAreaMsg").show();$("#vista_notif").hide();',
'style' => 'padding:4px 10px; margin-left:10px; color:#555',
]);
?>
</div>
</div>


<div id="vista_notif"  style="text-align:center; display:none">
	<br><br>
	<img src="<?= $logoURL?>" width="185px" height="95px" />
	<br><br>
	<img src="<?= Url::base('http') . '/images/notificacion.png'?>" width="453px" height="272px"/>
</div>

<div id="textAreaMsg">
<div class="col-sm-12">
<p align="center" style="color:#777; font-size:18px">Mensaje</p>
</div>    
<div class="col-sm-12">
<textarea id="mensaje-notificacion-text" 
		onkeyup="keyup_text()" 
		onmouseout="keyup_text()" 
		onmouseover="keyup_text()" 
		onblur="keyup_text()" 
		class="form-control notificacion-text" 
		rows="7"
		cols="10" 
		placeholder="Ingrese un mensaje adicional para notificar al cliente . . .">
</textarea>
</div>    

<button type="button" 
		id="btn_cerrar_modal" 
		onclick="document.getElementById('mensaje-notificacion-text').value = '';" 
		class="close" 
		data-dismiss="modal" 
		aria-hidden="true" 
		style="display:none">
×
</button>


<div class="col-sm-12">
<br>
</div>    

<div class="col-sm-18">
<div class="col-sm-1">
</div>    

<div class="col-sm-18">

<div class="col-sm-12" align="center">

<?php

$params = [
		'view' => 'facturasenc/notificar',
		'title' => 'notificando facturas . . .',
		'msg' => 'esto puede tardar algunos minutos',
		'color' => 'success',
];
$var_session = Formato::generateRandomLetters();
Yii::$app->session->set($var_session, $params);
 
echo Html::a('<span class="glyphicon glyphicon-envelope"></span> NOTIFICAR SIN MENSAJE',
		//             			['notificar'],
		['site/redirect', 'params' => $var_session],
		[
				'id' => 'btn_notificar_seleccion_modal',
				'class' => 'btn btn-block_ btn-primary',
				'name' => 'btn_notificar_modal',
				'data-toggle' => 'tooltip',
				'data-placement' => 'bottom',
				'title' => 'Este mensaje será enviado en cada una de las facturas seleccionadas',
				'target'=>'_blank',
				'onmouseover'=>'keyup_text()',
				'style' => 'display:none; padding:4px 25px; left:50%',
		]
);


echo Html::a('<span class="glyphicon glyphicon-envelope"></span> NOTIFICAR SIN MENSAJE',
['notificar'],
[
'id' => 'btn_notificar_individual_modal',
'name' => 'btn_notificar_modal',
'class' => 'btn btn-block_ btn-primary',
'data-toggle' => 'tooltip',
'data-placement' => 'bottom',
'title' => 'Este mensaje solo será enviado en la factura seleccionada',
'target'=>'_blank',
'onmouseover'=>'keyup_text()',
'style' => 'display:none; padding:4px 25px; left:50%',
]);

?>
</div>
</div>
</div>
</div>    


			    
<?php Modal::end();?> 

<div class="facturasenc-index">



    	<?php if ($CONFIG_msg_replyto_alert_visto < 10 && $ALERT_REPLYTO):?>
    	<div class="col-sm-12">
			<div id="alert_config_msg_" class="alert alert-info alert-dismissible" role="alert" >
			  <p class="close" >
			  <span aria-hidden="false">
			  </span>
			  </p>
			  <p style="font-size:15px" >
			  Ahora el receptor puede <b>responder la notificaci&oacute;n</b> de su factura. 
			  Las respuestas ser&aacute;n enviadas a las correos registrados en 
			  <a href="http://empresas.e-facturas.com.ar:85/index.php?r=mails" target="_blank" style="text-decoration:none; "><b>Configuraci&oacute;n > Emails</b>
			  </a>
			  <br><p>
			  </p>
			</div>
    	</div>
    	<br><br>

		<?php endif;?>    			

	
	<div class="col-sm-18">
	<div class="col-sm-3" align="left">
	<div style="font-size: 30px;">
    <?= Html::encode($this->title) ?>   
    </div>    	
    <?php if ($dataProvider == '') {
        Echo $msg;
    } else { ?>
		<?php if ($CONFIG->filtros):?>
		
			<?= $this->render('_index_filtrar_busqueda_compacto',['search' => $search, 'listComprobantes' => $listComprobantes]); ?>

  		<?php else : ?>  
 
			<?= $this->render('_index_filtrar_busqueda_amplio',['search' => $search, 'listComprobantes' => $listComprobantes]); ?>
				    
    	<?php endif;?>
            	
	</div>
	
	
	
	<div class="col-sm-9 ">


    	
    	
    	<?php if (!$CONFIG_msg_notif_alert_visto):?>
    	<div class="col-sm-10">
			<div id="alert_config_msg" class="alert alert-success alert-dismissible" role="alert" style="    padding-top: 10px;    padding-bottom: 10px;    margin-bottom: 0px;">
			  <p class="close" >
			  <span aria-hidden="false">
			  <span style="font-size:18px" class="glyphicon glyphicon-arrow-right"></span>
			  </span>
			  </p>
			  <p style="font-size:15px" >
			  Env&iacute;e un <strong>mensaje adicional</strong> al cliente en la notificaci&oacute;n de su factura.
			  <br><p>
			  </p>
			  <div class="col-sm-12" align="right" style="font-size:14px; color:#555; top:4px; left:25px" >
			  <i>No volver a mostrar este mensaje</i>
			  <input type="checkbox" id="check_config_msg_alert" 
			  style="transform: scale(1); margin-top:3px; margin-left:3px; position:absolute;"> 
			  </div>    	
			  <br>
			</div>
    	</div>
    	<div class="col-sm-2">
		<?php else : ?>
		<div class="col-sm-12">
		<?php endif;?>    	
    	
    	
			<?= $this->render('_index_config_default', ['CONFIG_msg_notif' => $CONFIG_msg_notif, 'logoURL' => $logoURL]); ?>
		</div>
	<div class="col-sm-8">
	</div>
	<div class="col-sm-4" align="right">
	<br>
	
	            <?php
	            
	            if ($CONFIG_msg_notif == true) {
	            	echo Html::a('<span class="glyphicon glyphicon-envelope"></span> Notificar',
	            			'#',
	            			[
	            					'class' => 'btn btn-primary',
	            					'name' => 'notificar-button',
	            					'data-toggle' => 'tooltip',
	            					'data-placement' => 'bottom',
	            					'title' => 'Seleccione las facturas a Notificar',	            					
	            			]
	            	);	            	
	            }
	            else {
	            	
		            $params = [
		            		'view' => 'facturasenc/notificar',
		            		'title' => 'notificando facturas . . .',
		            		'msg' => 'esto puede tardar algunos minutos',
		            		'color' => 'success',
		            ];
		            $var_session = Formato::generateRandomLetters();
		            Yii::$app->session->set($var_session, $params);
	            
		             echo Html::a('<span class="glyphicon glyphicon-envelope"></span> Notificar', 
	//             			['notificar'], 
	             			['site/redirect', 'params' => $var_session],
	            			[
	                            'class' => 'btn btn-primary', 
	                            'name' => 'notificar-button',
	                                'data-toggle' => 'tooltip',
	                                'data-placement' => 'bottom',
	                            'title' => 'Seleccione las facturas a Notificar',
	                            'target'=>'_blank'
	                        ]
	                    ); 
	            }
            ?>
            <?php
                $params = [
                        'view' => 'facturasenc/imprimir',
                        'title' => 'cargando datos facturas',
                        'msg' => 'esto puede tardar varios segundos',
                        'color' => 'warning',
                ];
                $var_session = Formato::generateRandomLetters();
                Yii::$app->session->set($var_session, $params);
            
             echo Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', 
//                      ['imprimir'], 
                        ['site/redirect', 'params' => $var_session],
                        [
                            'class' => 'btn btn-warning', 
                            'name' => 'imprimir-button',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                            'title' => 'Seleccione las facturas a Imprimir',
                            'target'=>'_blank'
						]
            		) ;
             ?>
	
        <br><br>
        </div>
        </div>
	</div>
	    	</div>



        <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'layout' => '{summary}{items}', // esto caga el paginador
//         'filterModel' => $search,
        'id' => 'grid',
        'rowOptions'=>($CONFIG_notificada_status == 0) ? '' : 
        		function($model){
        	
		        	if ($model->notificada == 1)
		        	{
		        		return ['class'=>'success'];
		        	}
		        	else
		        	{
		        		return ['class'=>'danger'];
		        	}
	        	}
        ,

        'columns' => $columns,
//         'tableOptions' =>['class' => 'table table-striped table-bordered table-hover table-condensed'],      
    ]); ?>

    <?php } ?>
</div>


<div class="col-sm-3 btn-block ">
<p id="bt-subir" class="btn-top ">
<a href="#" class="btn btn-default_ btn-large fijo">
<span class="glyphicon glyphicon-chevron-up"></span>
</a>
</p>
</div>  
  
<style> 

.btn-large {
background: rgba(0, 0, 0, 0.15); 
box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.2);
font-size: 24px;
color: #777;  
width: 100%;
height: 40px;
left:0px;
bottom:0px; 
}

.btn-large:hover {
background: rgba(0, 0, 0, 0.25); 
box-shadow: inset 0 7px 15px rgba(0, 0, 0, 0.4);
}


.fijo { 
position:fixed !important;
bottom:0px;  
z-index:10 !important 
} 

.color-si {
/*     color: #3c763d; */
	color: #337ab7;
}

.color-receptor-si
{
	color: #46b8da; 
}


.color-no {
    color: #a94442;
}

.notificacion-text {
	white-space: pre;
	resize: none;
/* 	overflow: hidden */
}




</style>

<?php

$script = <<< JS

$("#modal_msg").on('hidden.bs.modal', function () {
	resetVistaPrevia();
});		

$(".modal").on('hidden.bs.modal', function () {
	$('#vista_notif_config').hide();
});		

		
$("#btn_check_config_msg").on('click', function () {
	$(".modal-body").css("min-height", '60px');
});		
		
// $("#btn_check_config_msg").on('click', function () {
// 	$("#w4").css("height", '20px');
// });		
		

$(function () {

        $("[name='btn_notificar_modal']").click(function(){
		
		    var str = window.location;
		    var controller = String(str).replace("Findex", "Fset-mensaje-notificacion-factura");
			var mensaje = $("#mensaje-notificacion-text").val();
		    $.ajax({
		            url: controller,
		            type: 'post',
		            data: {msj:mensaje},
// 		         	success: function (data) {
// 		            	alert(data);
// 		       		}
			});
			var btn_sel = document.getElementById('btn_notificar_seleccion_modal');
			var btn_ind = document.getElementById('btn_notificar_individual_modal'); 
			var label = '<span class="glyphicon glyphicon-envelope"></span> NOTIFICAR SIN MENSAJE';
			btn_sel.innerHTML = label;
			btn_ind.innerHTML = label;
	
			$('#btn_notificar_seleccion_modal').animate({fontSize:'14px'}, 0);
			$('#btn_notificar_individual_modal').animate({fontSize:'14px'}, 0);
			$('#btn_notificar_seleccion_modal').animate({fontSize:'14px'}, 0);
			$('#btn_notificar_individual_modal').animate({fontSize:'14px'}, 0);
			document.getElementById('mensaje-notificacion-text').value = '';
			$("#btn_cerrar_modal").click(); 
			
		});
		
		
        $("[name='imprimir-button']").click(function(){

			isSelectedFactura();
		
			var str = window.location;
	        var controller = String(str).replace("Findex", "Fseleccionar-facturas");
	        
	        $.ajax({
	                url: controller,
	                type: 'post',
	                data: {pk:$('#grid').yiiGridView('getSelectedRows')},
	//              success: function (data) {
	//                  alert(data);
	//            }
	
	      		});
	        
 		});

        $("[name='notificar-button']").click(function(){

			if(isSelectedFactura()) {
			
		        var str = window.location;
		        var controller = String(str).replace("Findex", "Fseleccionar-facturas");
		        
		        $.ajax({
		                url: controller,
		                type: 'post',
		                data: {pk:$('#grid').yiiGridView('getSelectedRows')},
		//              success: function (data) {
		//                  alert(data);
		//            }
		
				      });
				
				
				if (CONFIG_msg_notif_JS == '1') {
		
					$("#btn_modal_mensaje").click();
					setTimeout("$('#btn_notificar_individual_modal').hide()", 100);
					setTimeout("$('#btn_notificar_seleccion_modal').show()", 200);
					$(".modal-body").css("min-height", '300px');
					setTimeout("document.getElementById(\"mensaje-notificacion-text\").focus()", 550);
				}
		        
			}
		});
				
		
		$("#check_config_msg").click(function(){
		
			y = document.getElementById('check_config_msg');
// 			y[0].checked = false;
		
			var check = (y.checked) ? '1': '0';
		
			var array_check = ['permite_msg_adicional', check];
			var str = window.location;
	        var controller = String(str).replace("Findex", "Fset-config-notificacion-factura");
	        
	        $.ajax({
	                url: controller,
	                type: 'post',
	                data: {config:array_check},
// 	             success: function (data) {
// 	                 alert(data);
// 	           }
	
	      		});
		
			setTimeout("location.reload();", 300);
			
	        
 		});
		
		
		$("#check_config_msg_alert").click(function(){
		
			y = document.getElementById('check_config_msg_alert');
// 			y[0].checked = false;
		
			var check = (y.checked) ? '1': '0';
		
			var array_check = ['alert_actualizacion_visto', check];
			var str = window.location;
	        var controller = String(str).replace("Findex", "Fset-config-notificacion-factura");
	        
	        $.ajax({
	                url: controller,
	                type: 'post',
	                data: {config:array_check},
// 	             success: function (data) {
// 	                 alert(data);
// 	           }
	
	      		});
		
			setTimeout(function() {
			    $("#alert_config_msg").fadeTo(600, 0).slideUp(600, function(){
			        $("#alert_config_msg").remove(); 
			    });
			}, 600);
			
	        
 		});		
        
  });

		
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
	$('#bt-subir').hide();
});  


$('#bt-subir').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 400);
		return false;
	});


	$(window).scroll(function() {
		if($(window).scrollTop() > 300) {  //cantidad de pixels que escrolleas para que se agregue scroll a header
			$('#bt-subir').fadeIn("slow");

		} else {
			$('#bt-subir').fadeOut("slow");
		}
	});
		

		

JS;
$this->registerJs($script);
?>

<script>
var CONFIG_msg_notif_JS =  "<?= $CONFIG_msg_notif?>";
var click_btn_vista_notif = 0;

function verVistaPrevia() {
	$("#textAreaMsg").stop();
	$("#vista_notif").stop();
	$("#textAreaMsg").toggle();
	$("#vista_notif").toggle();

	var btn_vista = document.getElementById('btn_vista_notif');

	if (click_btn_vista_notif == 0) {
		btn_vista.innerHTML = '<span class="glyphicon glyphicon-share-alt" style= "color:#555; font-size:14px"></span>';
		click_btn_vista_notif = 1;
	}
	else {
		btn_vista.innerHTML = '<span class="glyphicon glyphicon-picture" style= "color:#555; font-size:14px"></span>';
		click_btn_vista_notif = 0;
	}

}

function resetVistaPrevia() {
	$("#textAreaMsg").show();
	$("#vista_notif").hide();
	click_btn_vista_notif = 0;
	document.getElementById('btn_vista_notif').innerHTML = '<span class="glyphicon glyphicon-picture" style= "color:#555; font-size:14px"></span>';
}

function uncheckSelection() {

	y = document.getElementsByClassName('select-on-check-all');
	y[0].checked = false;
// 	document.getElementsByName("selection_all").checked = false;
	
	var x = document.getElementsByName("selection[]");
	var i;

	for (i = 0; i < x.length; i++) {
	    if (x[i].type == "checkbox") {
	        x[i].checked = false;
	    }
	}			
	

}

function keyup_text() {
	var btn_sel = document.getElementById('btn_notificar_seleccion_modal');
	var btn_ind = document.getElementById('btn_notificar_individual_modal'); 
	var t = document.getElementById("mensaje-notificacion-text");
// 	var text = t.value.trim();
// 	document.getElementById("mensaje-notificacion-text").value = text;
	var time = 150;
	var text = t.value;
	if (text == '') {
		
		$('#btn_notificar_seleccion_modal').stop();
		$('#btn_notificar_individual_modal').stop();

		var label = '<span class="glyphicon glyphicon-envelope"></span> NOTIFICAR SIN MENSAJE';
		btn_sel.innerHTML = label;
		btn_ind.innerHTML = label;

		$('#btn_notificar_seleccion_modal').animate({fontSize:'14px'}, time);
		$('#btn_notificar_individual_modal').animate({fontSize:'14px'}, time);
	}
	else {
		$('#btn_notificar_seleccion_modal').stop();
		$('#btn_notificar_individual_modal').stop();
		
		var label = '<span class="glyphicon glyphicon-envelope"></span> NOTIFICAR CON MENSAJE';
		btn_sel.innerHTML = label;
		btn_ind.innerHTML = label;
		$('#btn_notificar_seleccion_modal').animate({fontSize:'18px'}, time);
		$('#btn_notificar_individual_modal').animate({fontSize:'18px'}, time);
// 		$(".modal-body").animate({ "left": "-=25px" }, time);
// 		$(".modal-body").animate({ "left": "+=25px" }, time);
		
// 		alert(text);
	} 
// 	$("#mensaje-notificacion-text").text(trim(text));
	
}

function notificar_modal(facturaid = -1) {

// 	alert($('#grid').yiiGridView('setSelectedRows'));
	uncheckSelection();

    var str = window.location;
    var controller = String(str).replace("Findex", "Fseleccionar-facturas");
    
    $.ajax({
            url: controller,
            type: 'post',
            data: {pk:[facturaid]},
//          success: function (data) {
//              alert(data);
//        }

  });	
	
	$("#btn_modal_mensaje").click();
	setTimeout("$('#btn_notificar_seleccion_modal').hide()", 100);
	setTimeout("$('#btn_notificar_individual_modal').show()", 200);
	$(".modal-body").css("min-height", '300px');
	setTimeout("document.getElementById(\"mensaje-notificacion-text\").focus()", 550);

};

function isSelectedFactura() {

	var all_checked = Object.keys($('#grid').yiiGridView('getSelectedRows')).length;
	if (all_checked == 0) {
		alert('Debe seleccionar al menos una factura');
		return false;
	}
	//else if (all_checked > 70) {
	//	alert('Solo se notificarán hasta 50 facturas por vez');
	//	return true;
	//}
	return true;

}

window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 15000);
</script>

