<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Empresauseradmin */

$this->title = 'Usuario: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Empresauseradmins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresauseradmin-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'empresas.razonsocial',
            'username',
//             'auth_key',
//             'password_hash',
//             'password_reset_token',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'empresaid',
        ],
    ]) ?>

</div>
