<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VistasAudita */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vistas Auditas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vistas-audita-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'empresaid',
            'vistaid',
            'ultimo_ingreso',
            'ingreso_anterior',
            'status',
        ],
    ]) ?>

</div>
