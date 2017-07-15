<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Configuracionservicios */

// $this->title = $model->configid;
$this->params['breadcrumbs'][] = ['label' => 'Configuracion Servicios'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuracionservicios-view">

    <h1><?php // Html::encode($this->title) ?></h1>

    <p>
        
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar',
        	            		['update', 'id' => $model->configid],
        	            		['class' => 'btn btn-primary']
                    	)
                ?>
                    	
                    	
	</p>

    <?php 
    // se obtiene la descripcion correspondiente al servicioid
    $model->servicioid = $model->getServiciosArray()[$model->servicioid]; 
    ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//             'configid',
//             'empresaid',
            'servicioid',
//             'fecha',
            'carpeta',
            'carpetacae',
            'carpetaerror',
//             'produccion',
        ],
    ]) ?>

</div>
