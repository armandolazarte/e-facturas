<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EmpresasEmailSender */

// $this->title = $model->empresaid;
// $this->params['breadcrumbs'][] = ['label' => 'Empresas Email Senders', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;


$pass_string = '';
for ($i = 0; $i < strlen($model->password); $i++) {
	$pass_string .= '&#8226;';

}

$status_string = ($model->status) 
		? '<span class="glyphicon glyphicon-ok"></span> ACTIVO' 
		: '<span class="glyphicon glyphicon-remove"></span> INACTIVO';

$class_alert = ($model->status) ? 'alert-success' : 'alert-danger';

?>



<?= $this->render('_info', ['view' => True]) ?>
<div class="empresas-email-sender-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update'], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete'], 
		 [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar este email?',
                'method' => 'post',
            ],
        ]) 
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options'=>[
        
        		'class'=>'table table-striped table-bordered detail-view '.$class_alert 
    	],
        'attributes' => [
//             'empresaid',
	    	[
	    	'attribute' => 'nombre',
	    	'format' => 'raw',
	    	],
            'email',
            [
            'attribute' => 'password',
            'value' => $pass_string,
            'format' => 'raw',
            ],            
            [
            'attribute' => 'servidor_smpt',
//             'value' => $pass_string,
            'format' => 'raw',
            ],
            [
            'attribute' => 'puerto_smpt',
//             'value' => $pass_string,
            'format' => 'raw',
            ],                        
//             'hash_validate',

            [
            'attribute' => 'status',
            'value' => $status_string,
            'format' => 'raw',
            ],            
        ],
    ]) ?>

</div>
