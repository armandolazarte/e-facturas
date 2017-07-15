<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ComprobantesEnvio */

$this->title = $model->comprobanteenvioid;
$this->params['breadcrumbs'][] = ['label' => 'Empresas - Errores FE', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comprobantes-envio-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'comprobanteenvioid',
            'empresaid',
            'puntoventaid',
            'comprobanteid',
            'comprobantenro',
            'fechaenvio',
            'observaciones',
            'errores',
            'fecha_rechazo',
            'estadoid',
        ],
    ]) ?>

</div>
