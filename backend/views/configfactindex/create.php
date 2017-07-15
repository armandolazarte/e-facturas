<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Configfactindex */

$this->title = 'Create Configfactindex';
$this->params['breadcrumbs'][] = ['label' => 'Configfactindices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configfactindex-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
