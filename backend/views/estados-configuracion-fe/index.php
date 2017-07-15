<?php

use yii\helpers\Html;
use common\models\Formato;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EstadosConfiguracionFeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estados Configuracion FE';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="estados-configuracion-fe-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
    'rowOptions'=>function($model){
    	if($model->activo == 0)
    	{
    		return ['class'=>'danger'];
    	}else
    	{
    		return ['class'=>'success'];
    	}
    },
    	'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
//             'id',
            [
				'attribute' => 'titulo',
				'format' => 'raw',
// 				'value' => function ($model) {
// 								return Formato::htmlEntitiesToTildes($model->titulo);
//             				},
            ],
            [
	            'attribute' => 'descripcion',
            		'format' => 'raw',
// 	            'value' => function ($model) {
// 	            				return utf8_decode($model->descripcion);
//  	            				return Formato::htmlEntitiesToTildes(utf8_decode($model->descripcion));
// 	            			},
            ],

            [
            'attribute' => 'vista',
            'label' => "Link",
            'encodeLabel' => false,//por defecto es true. FALSE hace que interprete el contenido del label como HTML
            ],            
//             'activo',
            
            [
	            'attribute' => 'activo',
	            'filter' => ['1'=>'SI','0'=>'NO'],
            	'format' => 'html',
	            'value' => function ($model) {
	            				return $model->activo == '1' ? 
	            				"<span class='alert-success'><span class='glyphicon glyphicon-ok'></span></span>" : 
	            				"<span class='alert-danger'><span class='glyphicon glyphicon-remove'></span></span>";
	            			},
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
