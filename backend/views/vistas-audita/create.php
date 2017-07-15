<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VistasAudita */

$this->title = 'Create Vistas Audita';
$this->params['breadcrumbs'][] = ['label' => 'Vistas Auditas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vistas-audita-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
