<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EstadosConfiguracionFe */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estados Configuracion FE', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-configuracion-fe-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Eliminar item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
            'attribute' => 'titulo',
            'format' => 'raw',
            ],
            [
            'attribute' => 'descripcion',
            'format' => 'raw',
            ],
            'vista',
            'activo',
            'estado',
        ],
    ]) ?>

</div>
