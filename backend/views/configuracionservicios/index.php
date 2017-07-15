<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConfiguracionserviciosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Configuracionservicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuracionservicios-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (!$configServicio): ?>
    
    <p>
    
        <div class="well">
                <h4>Su empresa no tiene un servicio configurado.</h4>
                <br>
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Configurar Servicio',
                                ['create'],
                                ['class' => 'btn btn-warning']
                        )
                ?>
    </div>
    </p>

    
    <?php else: ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'configid',
//             'empresaid',
            'servicioid',
//             'fecha',
            'carpeta',
            'carpetacae',
            'carpetaerror',
            // 'produccion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

	<?php endif; ?>
</div>
