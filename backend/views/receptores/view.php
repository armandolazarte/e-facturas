<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Receptores */

$this->title = $model->receptorid;
$this->params['breadcrumbs'][] = ['label' => 'Receptores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$emails_string = '';
foreach ($model->emails as $email) {
	$emails_string .= '<p>' . $email . '</p>'; 
	
}

?>
<div class="receptores-view">


    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->receptorid], ['class' => 'btn btn-primary']) ?>        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            /*'receptorid',
            'documentoid',*/
            'cuit',
            'nombre',
            'direccion',
            'localidad',
            /*'provinciaid',*/
            /*'responsableid',*/
            'telefono',
            'mail',
            [
            'attribute' => 'mail',
            'label' => 'Emails',
            'value' => $emails_string,
            'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
