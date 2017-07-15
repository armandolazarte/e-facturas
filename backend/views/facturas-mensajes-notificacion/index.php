<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FacturasMensajesNotificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturas Mensajes Notificacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturas-mensajes-notificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Facturas Mensajes Notificacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'facturaid',
            'mensajeid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
