<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
			echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
			}
	?>
    
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo',
        	            		['create'],
        	            		['class' => 'btn btn-success'],
           		         		[
// 	            	        		'title' => 'Nuevo',
// 	                	    		'target'=>'_blank',
//                     				'data-pjax' => '0',
                    			]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//      'filterModel' => $searchModel,
    	'summary'=>'',
// 		'showFooter'=>true,
//      'showHeader' => true,
// 		'showOnEmpty'=>true,
		'emptyCell'=>'-',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'mail',

            [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'Acciones',
            'headerOptions' => ['width' => '50'],
            'template' => '{update} {delete}{link}',
            'buttons' => [
            		'update' => function ($url, $model, $key) {
            			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
            					'title' => 'Editar email',
            			]);
            		},
            		'delete' => function ($url, $model, $key) {
            			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            					'title' => 'Eliminar email',
            					'data-confirm' => '¿Desea eliminar el email ' . $model->mail . '?',
            					'data-method' => 'post',
            			]);
            		},
            		]
            ],
        ],
//         'tableOptions' =>['class' => 'table table-striped table-bordered'],
    ]); ?>

</div>
