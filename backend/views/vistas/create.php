<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Vistas */

$this->title = 'Crear Vista';
$this->params['breadcrumbs'][] = ['label' => 'Vistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vistas-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
