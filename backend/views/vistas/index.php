<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VistasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vistas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vistas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo', 
        ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

    	[
    	'headerOptions' => ['width' => '100'],
           'attribute'=>'id',
    	],
            'descripcion',

            [
				'class' => 'yii\grid\ActionColumn',
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
    ]); ?>

</div>
