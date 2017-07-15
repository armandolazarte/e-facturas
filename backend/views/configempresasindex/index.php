<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConfigempresasindexSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configempresasindices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configempresasindex-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Configempresasindex', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'empresaid',
            'fchdde',
            'fchhta',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
