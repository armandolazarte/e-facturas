<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Formato;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmpresasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

	var frm = document.getElementsByTagName("input");

	for (i = 0; i < frm.length; i++) {
		if (frm[i].name == "EmpresasSearch[razonsocial]") {
			frm[i].focus();
			break;
    	}
	}

JS;
$this->registerJs($script);

?>

<div class="table-responsive">
    
<?php //echo $this->render('_fechas_cae',['fechas' => $fechas]); ?>    

<div class="col-sm-12">
<div class="col-sm-6">
<h3><?= Html::encode($this->title) ?></h3>
</div>
<div class="col-sm-6" align="right">
<h3>
<?= Html::button('<span class="glyphicon glyphicon-calendar"></span> Fechas CAE', ['value'=>Url::to('index.php?r=configempresasindex/update'),'class' => 'btn btn-default active','id'=>'modalButton']) ?>
</h3>
</div>
</div>

    <?php
        Modal::begin([
                'header'=>'<div align="center"><h4>Fechas Facturas CAE </h4></div>',
                'id' => 'modal',
                'size'=>'modal-sm',
            ]);
     
        echo "<div id='modalContent'></div>";
     
        Modal::end();
    ?>


<div class="empresas-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);    ['id'=>'branchesGrid']?>

    
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'rowOptions'=>function ($data) {
			if ($data->cuitasociado > 0) {
        		return ['class'=>'success'];
        	}
        	elseif ($data->cuitasociado == 0) {
        		return ['class'=>'danger'];
        	}
        	else {
        		return ['class'=>'well'];
        	}
        },        
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

            
            [
				'headerOptions' => ['width' => '60', 'style' => 'text-align: center'],
            	'attribute' => 'empresaid',
            	'label' => 'ID',
            	'format' => 'raw',
            	'value' => function ($data) {
            			return '<div style="margin-top:3px; text-align: right">' .
            					$data->empresaid .
            					'</div>';
            		},            		
			],     

			[
// 				'headerOptions' => ['width' => '200'],
				'attribute' => 'razonsocial',
				'label' => 'Razon Social',
				'format' => 'raw',
				'value' => function ($data) {
					return '<div style="margin-top:3px">' .
							$data->razonsocial .
							'</div>';
					},					
			],
			
			[
				'headerOptions' => ['width' => '120'],
				'attribute' => 'nrocuit',
				'label' => 'Nro Cuit',
				'format' => 'raw',
				'value' => function ($data) {
					return '<div style="margin-top:3px">' .
							$data->nrocuit .
							'</div>';
					},					
			],
			            
// 			[
// 				'headerOptions' => ['width' => '120'],
// 				'attribute' => 'nroiibb',
// 				'label' => 'Nro IIBB',
// 				'format' => 'raw',
// 			],
			
// 			[
// 			'headerOptions' => ['width' => '120'],
// 				'attribute' => 'inicioact',
// 				'label' => "Inicio Act",
// 				'value' => function ($data) {
// 					return Formato::fecha_mes($data->inicioact);
// 				},
// 			],

					
			// MAX Notificada 
// 			[
// 			'headerOptions' => ['width' => '120', 'class'=>'info_'],
// 			'attribute' => 'telefono',
// 			'label' => 'MAX Notificada',
// 			'format' => 'html',
// 			'contentOptions'=>['style' => 'text-align: center;'],
// 			'value' => function ($data) {
// 				$div = '<div style="margin-top:3px">@data</div>';
// 				if ($data->cuitasociado > 0)
// 					return str_replace('@data', Formato::fecha_mes($data->telefono), $div);
// 				else
// 					return str_replace('@data', '-', $div);
// 			},
			
// 			],
			
			
			// min fecha factura con cae
// 			[
// 				'headerOptions' => ['width' => '120', 'class'=>'breadcrumb_'],
// 				'attribute' => 'url',
// 				'label' => "MIN fecha CAE",
// 				'contentOptions'=>['style' => 'text-align: center'],
// 				'format' => 'html',
// 				'value' => function ($data) {
// 					$div = '<div style="margin-top:3px">@data</div>';
// 					if ($data->cuitasociado > 0) 
// 						return str_replace('@data', Formato::fecha_mes($data->url), $div);
// 					else
// 						return str_replace('@data', '-', $div);
// 				},
// 			],			

			// max fecha factura con cae
			[
				'headerOptions' => ['width' => '130', 'class'=>'breadcrumb_', 'style' => 'text-align: center'],
				'attribute' => 'fechabaja',
				'label' => "MAX Fecha CAE",
				'contentOptions'=>['style' => 'text-align: center'],
				'format' => 'html',
				'value' => function ($data) {
						$div = '<div style="font-size: 18px">@data</div>';
						if ($data->cuitasociado > 0)
							return str_replace('@data', Formato::fecha_mes($data->fechabaja), $div);
						else
							return str_replace('@data', '-', $div);					
					},
			],
			

			// cantidad de facturas con cae
			[	
				'headerOptions' => ['width' => '120', 'class'=>'success_', 'style' => 'text-align: center'],
				'attribute' => 'cuitasociado',
				'label' => "Facturas CAE",
				'contentOptions'=>['style' => 'text-align: right; font-size: 18px'],					
				'format' => 'raw',
				'value' => function ($data) {
						if ($data->cuitasociado > 0) {
							return Html::a('<b>'.$data->cuitasociado.'</b>',
									['comprobantes','id' => $data->empresaid],
									[
										'title' => 'Ver detalle',
										'target'=>'_blank',
										'data-pjax' => '0',
									]
							);
						}
						else {
							return '-';
						}
					}
			],			
				
				
            // 'prestadorid',
            // 'responsableid',
            // 'calle',
            // 'nro',
            // 'piso',
            // 'depto',
            // 'cp',
            // 'manzana',
            // 'localidad',
            // 'sector',
            // 'provinciaid',
            // 'torre',
            // 'url:url',
            // 'cuponpf',
            // 'gln',
            // 'fechabaja',
            // 'email:email',

            [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '40'],
            'template' => '<div style="margin-top:3px; text-align: center">{view}</div>',
            

            		//'headerOptions' => ['width' => '60'],
                'buttons' => [
                    'view' => function ($action, $model, $key) {
		                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
        	            		['view','id' => $model->empresaid],
           		         		[
	            	        		'title' => 'Ver',
	                	    		'target'=>'_blank',
                    				'data-pjax' => '0',
                    			]
                    		);
                    	 },

                    ],

            ],
            //['class' => 'yii\grid\CheckboxColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
	</div>
</div>

