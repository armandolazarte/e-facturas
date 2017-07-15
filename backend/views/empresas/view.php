<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Empresas */

$this->title = $model->razonsocial;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresas-view">

    <h3><?= Html::encode($this->title) ?></h3>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'empresaid',
            'nrocuit',
            'razonsocial',
            'nroiibb',
            'inicioact',
            'prestadorid',
            'responsableid',
            'calle',
            'nro',
            'piso',
            'depto',
            'cp',
            'manzana',
            'localidad',
            'sector',
            'provinciaid',
            'torre',
            'telefono',
            'url:url',
            'cuponpf',
            'gln',
            'fechabaja',
            'cuitasociado',
            'email:email',
        ],
    ]) ?>

</div>
