<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\models\Formato;

$empresaid = Yii::$app->user->identity->empresaid;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ComprobantesEnvioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Errores FE';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="comprobantes-envio-index">


<div class="col-sm-12">
<div class="col-sm-6">
<h3><?= Html::encode($this->title) ?></h3>
</div>
<div class="col-sm-6" align="right">
<h3>
<?= Html::button('<span class="glyphicon glyphicon-calendar"></span>', ['value'=>Url::toRoute(['config-periodo-errores-fe/update', 'id' => $empresaid]),'class' => 'btn btn-default active','id'=>'modalButton']) ?>
</h3>
</div>
</div>

    <?php
        Modal::begin([
                'header'=>'<div align="center"><h4>Periodo Errores FE </h4></div>',
                'id' => 'modal',
                'size'=>'modal-sm',
            ]);
     
        echo "<div id='modalContent'></div>";
     
        Modal::end();
    ?>


    <?php if (count($query_errores) == 0): ?>

        <?= $this->render('no_hay_errores'); ?>

    <?php else: ?>
	
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '<b style="color:#fff">.</b>',
        'rowOptions'=>function($model){
        	if($model['observaciones'] == '')
        	{
        		return ['class'=>'warning'];
        	}else
        	{
        		return ['class'=>'danger'];
        	}
        },
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

            
//     'comprobanteenvioid',
	                        
        		[
        		'headerOptions' => ['width' => '60', 'style'=>'text-align: center'],
        		'contentOptions'=>[ 'style'=>'text-align: center'],
        		'attribute'=>'puntoventaid',
        		'label' => "PV",
        		'value'=>'puntoventaid',
        		],

        		[
        		'headerOptions' => ['width' => '60', 'style' => 'text-align: center'],
        		'attribute' => 'comprobanteid',
        		'label' => "Cpte",
        		'contentOptions'=>['style' => 'text-align: center'],
        		'value' => function ($data) {
        			$fe = $data['comprobanteid'];
        			if ($fe === 'FACTURA A') $fe = 'A';
        			else if ($fe === 'FACTURA B') $fe = 'B';
        			else if ($fe === 'NOTA DE CREDITO A') $fe = 'NCA';
        			else if ($fe === 'NOTA DE CREDITO B') $fe = 'NCB';
        			else if ($fe === 'NOTA DE DEBITO A') $fe = 'NDA';
        			else if ($fe === 'NOTA DE DEBITO B') $fe = 'NDB';
        		
        			return $fe;
        		},
        		],
        		
        		[
        		'headerOptions' => ['width' => '60', 'style'=>'text-align: center'],
        		'contentOptions'=>[ 'style'=>'text-align: center'],
        		'attribute'=>'comprobantenro',
        		'label' => "Número",
        		'value'=>'comprobantenro',
        		],
        		
//         		[
//         		'headerOptions' => ['width' => '100', 'style'=>'text-align: center'],
//         		'contentOptions'=>[ 'style'=>'text-align: center'],
//         		'attribute'=>'fechaenvio',
//         		'label' => "Envio",
//         		'value'=>'fechaenvio',
//         		],


        		
        		[
        		'headerOptions' => ['width' => '100', 'style'=>'text-align: center'],
        		'contentOptions'=>[ 'style'=>'text-align: center'],
        		'attribute'=>'fecha_rechazo',
        		'label' => "Rechazo",
				'value' => function ($data) {
						return Formato::fechaHora($data['fecha_rechazo']);
        			},        				
        		],        		


        		[
        		'headerOptions' => ['style' => 'text-align: center'],
        		'contentOptions'=>[ 'style'=>'text-align: left'],
        		'attribute'=>'observaciones',
        		'format' => "raw",
        		'label' => "Observaciones",
        		'value' => function ($data) {
        			return Formato::erroresCae($data['observaciones']);
        		},
        		],
        		

        		[
        		'headerOptions' => ['style' => 'text-align: center'],
        		'contentOptions'=>[ 'style'=>'text-align: left'],
        		'attribute'=>'errores',
        		'format' => "raw",
        		'label' => "Errores",
        		'value' => function ($data) {
        			return Formato::erroresCae($data['errores']);
        		},
        		],
        		        		

//             'estadoid',

        		[
        		'class' => 'yii\grid\ActionColumn',
        		'headerOptions' => ['width' => '20'],
        		'template' => '<div text-align: center">{view}</div>',
        		'buttons' => [
        				'view' => function ($action, $model, $key) {
        				
	        				$params = [
                                    'empresaid' => '',
	        						'facturaid' => $model['estadoid'],
	        						'puntoventa' => $model['puntoventaid'],
	        						'comprobante' => $model['comprobanteid'],
	        						'fecha_rechazo' => $model['fecha_rechazo'],
	        						'observaciones' => $model['observaciones'],
	        						'errores' => $model['errores']
	        				];
	        				$var_session = Formato::generateRandomLetters();
	        				Yii::$app->session->set($var_session, $params);
        				
        					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
        							['get-envio', 'params' => $var_session],
        							[
										'title' => 'Ver',
        								'target'=>'_blank',
        								'data-pjax' => '0',
        							]
        					);
        				},
        		
        				],
        		
        				],        		

        ],
        'tableOptions' =>['class' => 'table table-striped table-bordered table-hover table-condensed'],
    ]); ?>
    <?php Pjax::end(); ?>


<?php endif; ?>


</div>
