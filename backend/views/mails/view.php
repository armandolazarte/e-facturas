// <?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Mails */

$this->title = $model->mailid;
$this->params['breadcrumbs'][] = ['label' => 'Mails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->mailid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->mailid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar este mail?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//             'mailid',
//             'empresaid',
            'nombre',
            'mail',
        ],
    ]) ?>

</div>
