<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Empresauseradmin */

$this->title = 'Create Empresauseradmin';
$this->params['breadcrumbs'][] = ['label' => 'Empresauseradmins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresauseradmin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
