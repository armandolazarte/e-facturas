<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Empresauseradmin */

$this->title = 'Update Empresauseradmin: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Empresauseradmins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="empresauseradmin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
