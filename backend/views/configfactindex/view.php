<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Configfactindex */

$this->title = $model->empresaid;
$this->params['breadcrumbs'][] = ['label' => 'Configfactindices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configfactindex-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->empresaid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->empresaid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'empresaid',
            'fchdde',
            'fchhta',
            'pagesize',
            'filtros',
            'notificada_color_status',
            'orden1_campo',
            'orden1_tipo',
            'orden2_campo',
            'orden2_tipo',
        ],
    ]) ?>

</div>
