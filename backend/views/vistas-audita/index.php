<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VistasAuditaSearch */
/* @var var_dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vistas Audita';
$this->params['breadcrumbs'][] = ['label' => 'Vistas Audita', 'url' => ['index']];

//echo '<br><br><br>';
//echo $HOY = date('Y-m-d');
?>

<div class="vistas-audita-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php //echo Html::a('Create Vistas Audita', ['create'], ['class' => 'btn btn-success']) ?>

<center>
<a class="btn btn-sm btn-default" style="font-size: 14px; color:#337ab7" 
href="http://empresas.e-facturas.com.ar/index.php?VistasAuditaSearch%5Bempresaid%5D=&VistasAuditaSearch%5Bvistaid%5D=&VistasAuditaSearch%5Bultimo_ingreso%5D=<?=date('Y-m-d')?>&VistasAuditaSearch%5Bingreso_anterior%5D=&VistasAuditaSearch%5Bcontador%5D=&VistasAuditaSearch%5Bstatus%5D=&r=vistas-audita%2Findex">HOY</a>

</center>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//         'showFooter'=>true,
//         'showHeader' => false,
// 			'showOnEmpty'=>true,
//     		'emptyCell'=>'-',
    
        'rowOptions'=>function($model){
        	if($model->status == 0)
        	{
        		return ['class'=>'danger'];
        	}else
        	{
        		return ['class'=>'success'];
        	}
        },
        'summary'=>'',        
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

//             'id',
//             'empresaid',
            [
            'headerOptions' => ['width' => '50'],
            'attribute'=>'ID',
            //         		'label' => "ID",
            'value'=>'empresaid',
            ],
            
            [
            'attribute'=>'empresaid',
            'label' => "Empresa",
            'value'=>'empresas.razonsocial',
            // 	            'contentOptions'=>[ 'style'=>'color:#000000'],
            ],
            
            [
            'attribute'=>'vistaid',
            'label' => "Vista",
            'value'=>'vistas.descripcion',
            // 	            'contentOptions'=>[ 'style'=>'color:#000000'],
            ],
            

//             'vistaid',
            'ultimo_ingreso',
            'ingreso_anterior',
        		
        		[
        		'headerOptions' => ['width' => '100'],
        				'contentOptions'=>[ 'style'=>'text-align: right'],
        		'attribute'=>'contador',
        		'label' => "Contador",
        		'value'=>'contador',
        		],        		
            [
            'attribute' => 'status',
            'filter' => ['1'=>'SI','0'=>'NO'],
            'format' => 'html',
            'headerOptions' => ['width' => '40'],
            // 				'contentOptions'=>[ 'width' => '40'],
            'value' => function ($model) {
            	return $model->status == '1' ?
            	"<span class='alert-success'><span class='glyphicon glyphicon-ok'></span></span>" :
            	"<span class='alert-danger'><span class='glyphicon glyphicon-remove'></span></span>";
            },
            ],            

            [
				'class' => 'yii\grid\ActionColumn',
            		'header'=>'Action',
            	'headerOptions' => ['width' => '40'],
            	'template' => '{update}',
            	'buttons' => [
            			'view' => function ($action, $model, $key) {
            				return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
            						['view','id' => $model->id],
            						[
            								'title' => 'Ver',
            								'target'=>'_blank',
            								'data-pjax' => '0',
            						]
            				);
            			},
            	
            			'update' => function ($action, $model, $key) {
            				return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
            						['update','id' => $model->id],
            						[
            								'title' => 'Actualizar',
            								'target'=>'_blank',
            								'data-pjax' => '0',
            						]
            				);
            			},
            	
            			],
            			 
			],
				
        ],
// 			'options'=>['class'=>'grid-view gridview-newclass'],
// 		'tableOptions' =>['class' => 'table table-striped table-bordered'],
//		'tableOptions' =>['class' => 'table table-striped '],
		
    ]); ?>

</div>




<script>

function verHoy() {
    alert(document.getElementsByName("VistasAuditaSearch[ultimo_ingreso]").value);
    //document.getElementsByName("VistasAuditaSearch[ultimo_ingreso]").value = '2016-06-21';
}
</script>
