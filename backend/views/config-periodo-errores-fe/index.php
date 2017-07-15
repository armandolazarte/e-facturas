<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConfigPeriodoErroresFeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Config Periodo Errores ves';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-periodo-errores-fe-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Config Periodo Errores Fe', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'empresaid',
            'periodo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
