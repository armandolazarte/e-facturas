<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EstadosConfiguracionFe */

$this->title = 'Crear Estados Configuracion FE';
$this->params['breadcrumbs'][] = ['label' => 'Estados Configuracion FE', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-configuracion-fe-create">

<div align="center">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
<br>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
