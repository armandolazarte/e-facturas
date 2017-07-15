<?php

use yii\helpers\Html;
use common\models\Formato;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MensajesEmpresasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensajes Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-empresas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Mensaje Nuevo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'mensajeid',
            [
            'contentOptions'=>['width' => '160'],
            'attribute' => 'empresaid',
            ],
//             'empresa',
            [
				'attribute' => 'titulo',
				'format' => 'raw',
				'value' => function ($model) {
								return Formato::htmlEntitiesToTildes($model->titulo);
            				},
            ],
//             'sizetitulo',
//             'descripcion:ntext',
            [
            'attribute' => 'descripcion',
            'format' => 'raw',
            'value' => function ($model) {
            	return Formato::htmlEntitiesToTildes($model->descripcion);
            },
            ],
            // 'textalign',
            // 'colorfondo',
            // 'vista',
            'vigenciadesde',
            'vigenciahasta',
            'activo',
//             'permitecerrar',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
     
     ?>

</div>
