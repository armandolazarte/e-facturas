<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConfigfactindexSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configfactindices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configfactindex-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Configfactindex', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'empresaid',
            'fchdde',
            'fchhta',
            'pagesize',
            'filtros',
            // 'notificada_color_status',
            // 'orden1_campo',
            // 'orden1_tipo',
            // 'orden2_campo',
            // 'orden2_tipo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
