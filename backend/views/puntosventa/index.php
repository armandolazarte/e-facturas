<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PuntosventaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Puntos de Venta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="puntosventa-index">

    <h4><?php // Html::encode($this->title) ?></h4>
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

            'puntoventa',
            'descripcion',

            [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'Acciones',
            'headerOptions' => ['width' => '50'],
            'template' => '{update} {delete}{link}',
            'buttons' => [
            		'update' => function ($url, $model, $key) {
            			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
            					'title' => 'Editar Punto Venta',
            			]);
            		},
            		'delete' => function ($url, $model, $key) {
            			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            					'title' => 'Eliminar Punto Venta',
            					'data-confirm' => '¿Desea eliminar el punto de venta ' . $model->puntoventa . '?',
            					'data-method' => 'post',
            			]);
            		},
            		]
    		],
        ],
    ]); ?>

</div>

<?php

$script = <<< JS
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>

