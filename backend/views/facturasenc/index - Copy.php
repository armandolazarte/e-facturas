<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Formato;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Facturas';
// $this->params['breadcrumbs'][] = $this->title;

$listComprobantes=ArrayHelper::map($comprobantes,'comprobanteid','descripcion');
$listComprobantes[0]='TODOS';

$CONFIG_notificada_status = $CONFIG->notificada_color_status;

?>

<div class="facturasenc-index">

	<?= $this->render('_index_config_default'); ?>

    <h2><?= Html::encode($this->title) ?></h2>   

    <?php if ($dataProvider == '') {
        Echo $msg;
    } else { ?>
	
		<?php if ($CONFIG->filtros):?>
		
			<?= $this->render('_index_filtrar_busqueda_compacto',['search' => $search, 'listComprobantes' => $listComprobantes]); ?>

  		<?php else : ?>  
 
			<?= $this->render('_index_filtrar_busqueda_amplio',['search' => $search, 'listComprobantes' => $listComprobantes]); ?>
				    
    	<?php endif;?>

    	
        <div align="right">
            <?php
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
                                'data-placement' => 'top',
                            'title' => 'Seleccione las facturas a Notificar',
                            'target'=>'_blank'
                        ]
                    ) 
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
                                'data-placement' => 'top',
                            'title' => 'Seleccione las facturas a Imprimir',
                            'target'=>'_blank'
						]
            		) 
            ?>
        </div>
        <br>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'layout' => '{summary}{items}',
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

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'facturaid',
		
            [
	            'attribute' => 'Cliente',
        		'value' => 'clienteid',
            ],
//             'receptorid',

			[
        		'attribute' => 'Nombre',
        		'value' => 'nombre',
			],        		
			[
        		'attribute' => 'Direccion',
        		'value' => 'direccion',
        	],
            [
    	        'attribute' => 'Fecha',
//	 			'label' => "Fecha",            		
    	        'value' => function ($data) {
        	            return Formato::fecha($data->fechafactura);
            	    },
            ],
            [
				'contentOptions'=>['width' => '40'],
				'attribute' => 'Punto Venta',
				'label' => "PV",            		
            	'value' => function ($data) {
                    	return $data->puntoventa0->puntoventa;
                	},
             	],
            [
				'attribute' => 'Comprobante',
// 				'label' => "Comprobante",            		
             	'value' => function ($data) {
                	    return str_replace('FACTURAS', 'FACTURA', $data->comprobante->descripcion);
                	},
             	],
            [
	            'attribute' => 'Numero',
				'label' => 'Numero',            		
        	    'value' => 'comprobantenro',
            ],
            [
            	 'attribute' => 'Importe Total',
             	'value' => function ($data) {
                	    return '$ '.$data->facturaspies[0]->importetotal;
                	},
			],
            // 'responsableid',
            // 'localidad',
            // 'provinciaid',
            // 'telefono',
            // 'email:email',
            // 'url:url',
            // 'conceptoid',

			['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn', 
                'template' => '{ver} &nbsp; {notificar}',
            		'headerOptions' => ['width' => '60'],
                'buttons' => [
                    'ver' => function ($action, $model, $key) {
		                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
        	            		['view','id' => $model->facturaid],
           		         		[
           		         				'id' =>'x',
	            	        		'title' => 'Ver',
	                	    		'target'=>'_blank',
                    				'data-pjax' => '0',
                    			]
                    		);
                    	 },
                   	 'notificar' => function ($action, $model, $key) {
                    	 	return Html::a('<span class="glyphicon glyphicon-envelope"></span>',
                    	 			['notificar','id' => $model->facturaid],
                    	 			[
                    	 					'title' => 'Notificar',
                    	 					'target'=>'_blank',
                    	 					'data-pjax' => '0',
                    	 			]
                    	 	);
                    	 }
                ],
            ],
//             ['class' => 'yii\grid\CheckboxColumn'],
        ],
        
    ]); ?>

    <?php } ?>
</div>

  
<?php

$script = <<< JS
$(function () {

        $("[name='imprimir-button']").click(function(){
//          $('#xx').click(function(){
//      alert($('#grid').yiiGridView('getSelectedRows'));
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
//          $('#xx').click(function(){
//      alert($('#grid').yiiGridView('getSelectedRows'));
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
        
  });

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});  

JS;
$this->registerJs($script);
?>
