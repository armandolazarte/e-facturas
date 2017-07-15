<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmpresauseradminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas - Usuarios';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
		
	var frm = document.getElementsByTagName("input");

	for (i = 0; i < frm.length; i++) {
		if (frm[i].name == "EmpresauseradminSearch[empresaid]") {
			frm[i].focus();
			break;
    	}
	}				

JS;
$this->registerJs($script);



?>
<div class="empresauseradmin-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            ['class' => 'yii\grid\SerialColumn'],

//             'id',
            
			[
				'headerOptions' => ['width' => '60'],
        		'attribute'=>'ID',
//         		'label' => "ID",
        		'value'=>'empresaid',
        	],        		
        		
            [
            		'contentOptions' => ['id'=>'empresa_id'],
	            'attribute'=>'empresaid',
	            'label' => "Empresa",
	            'value'=>'empresas.razonsocial',
// 	            'contentOptions'=>[ 'style'=>'color:#000000'],
            ],            

			[
        		'attribute'=>'username',
        		'label' => "Usuario",
        		'value'=>'username',
        		// 	            'contentOptions'=>[ 'style'=>'color:#000000'],
        	],
            
//             'auth_key',
//             'password_hash',
//             'password_reset_token',
            'email:email',
//             'status',
            // 'created_at',
            // 'updated_at',
            
			[
        		'attribute' => 'status',
        		'filter' => ['10'=>'SI','0'=>'NO'],
        		'format' => 'html',
				'headerOptions' => ['width' => '40'],
// 				'contentOptions'=>[ 'width' => '40'],
        		'value' => function ($model) {
        			return $model->status == '10' ?
        			"<span class='alert-success'><span class='glyphicon glyphicon-ok'></span></span>" :
        			"<span class='alert-danger'><span class='glyphicon glyphicon-remove'></span></span>";
        		},
			],        		
        		

            [
				'class' => 'yii\grid\ActionColumn',
            	'headerOptions' => ['width' => '40'],
            	'template' => '{view}',
			],
        ],
    ]); ?>

</div>
