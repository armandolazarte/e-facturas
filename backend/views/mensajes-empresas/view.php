<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MensajesEmpresas */

$this->title = $model->mensajeid;
$this->params['breadcrumbs'][] = ['label' => 'Mensajes Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-empresas-view">

    <h1><?php // Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->mensajeid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->mensajeid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Eliminar este mensaje?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//             'mensajeid',
            'empresaid',
//             'empresa',
            [
            'attribute' => 'titulo',
            'format' => 'raw',
            ],
            [
            'attribute' => 'descripcion',
            'format' => 'raw',
            ],
            'sizetitulo',
            'textalign',
            'colorfondo',
            'vista',
            'vigenciadesde',
            'vigenciahasta',
            'activo',
            'permitecerrar',
        ],
    ]) ?>

</div>
