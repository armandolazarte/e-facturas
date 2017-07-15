<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Email;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receptores';
// $this->params['breadcrumbs'][] = $this->title;

$class_todos = ($searchModel->filtro_principal === 'TODOS') ? 'btn btn-default active' : 'btn btn-default';
$class_sin_mail = ($searchModel->filtro_principal === 'SIN EMAIL') ? 'btn btn-default active' : 'btn btn-default';
$class_con_mail = ($searchModel->filtro_principal === 'CON EMAIL') ? 'btn btn-default active' : 'btn btn-default';

?>
<div class="receptores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-sm-12">
    <div class="col-sm-5">
	<?= $this->render('_index_filtrar_busqueda',['searchModel' => $searchModel]); ?>
	</div>
	
	<div class="col-sm-7">
	<div class="btn-group" role="group" aria-label="...">
	  <button id="btn_con_email" type="button" class="<?= $class_con_mail?>">Con Email</button>
	  <button id="btn_todos" type="submit" class="<?= $class_todos?>">TODOS</button>
	  <button id="btn_sin_email" type="button" class="<?= $class_sin_mail?>">Sin Email</button>
	</div>
	</div>
	</div>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions'=>function($data){
        	if (Email::validate($data->mail)) {
        		return ['class'=>'success'];
        	}
        	else if ($data->mail == '') {
        		return ['class'=>''];
        	}
        	else {
        		return ['class'=>'danger'];
        	}
        },        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'receptorid',
            /*[
             'attribute' => 'responsable',
             'value' => function ($data) {
                    return $data->responsable->responsable;
                },
             ],*/
            'cuit',
            [
            'attribute' => 'nombre',
            'value' => function ($data) {
            		return utf8_decode(substr($data->nombre, 0, 20));
            	},            
            ],
            [
            'attribute' => 'direccion',
            'value' => function ($data) {
            	return utf8_decode(substr($data->direccion, 0, 20));
            },
            ],
            [
            'attribute' => 'localidad',
            'value' => function ($data) {
                return utf8_decode($data->localidad);
            },
            ],                        
            // 'provinciaid',
            // 'responsableid',
            'telefono',
            'mail',

            [
            	'class' => 'yii\grid\ActionColumn', 
            	'template' => '{view} {update}',
				'headerOptions' => ['width' => '50'],
            		'buttons' => [
            				'view' => function ($action, $model, $key) {
            					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
            							['view','id' => $model->receptorid],
            							[
            									'title' => 'Ver',
            									'target'=>'_blank',
            									'data-pjax' => '0',
            							]
            					);
            				},
            				'update' => function ($action, $model, $key) {
            					return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
            							['update','id' => $model->receptorid],
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

</div>

<?php 
$script = <<< JS

$('#btn_con_email').click(function(){
	document.getElementById('receptoressearch-filtro_principal').value = 'CON EMAIL';
	$("#btn_buscar").click();
});

$('#btn_sin_email').click(function(){
	document.getElementById('receptoressearch-filtro_principal').value = 'SIN EMAIL';
	$("#btn_buscar").click();
});

$('#btn_todos').click(function(){
	document.getElementById('receptoressearch-filtro_principal').value = 'TODOS';
	$("#btn_buscar").click();
});

		
		

JS;
$this->registerJs($script);
?>

