<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FacturasDebuggerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturas Debuggers';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="facturas-debugger-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if($factura_debug === null) echo Html::a('Create Facturas Debugger', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'facturaid',
            'height_barcode',
            'width_barcode',
            'font_barcode',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
