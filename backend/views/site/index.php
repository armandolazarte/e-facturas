<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use common\models\Formato;
use yii\bootstrap\Modal;

$this->title = 'Airtech - Consola factura electronica';


// 	    	print_r($mensajes_empresa);
// 	    	exit;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Bienvenidos!</h1>

        <p>a la consola de factura electronica donde podra imprimir las facturas y chequear el estado de sus servicios.</p>
        <?php if ((Yii::$app->user->isGuest)): ?>
        
        	<p>
        	<?= Html::a('Registrate', ['signup'], ['class' => 'btn btn-lg btn-success', 'name' => 'datos-button']);?>
 			</p>   
    
	    <?php endif; ?>
    
    

        </div>
</div>    