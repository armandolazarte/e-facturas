<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'Airtech Factura Electronica';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Bienvenido!</h1>

        <p class="lead">a la consola de factura electronica donde podra visualizar e imprimir sus facturas.</p>

        
        <?php if ((Yii::$app->user->isGuest)): ?>
        
	        <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
	        <p><?= Html::a('Registrate', ['signup'], ['class' => 'btn btn-lg btn-success', 'name' => 'datos-button']); ?></p>
    
	    <?php endif; ?>
           
        
    </div>
    
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Mis Datos</h2>

                <p>Esta seccion muestra los datos cargados al momento de la registracion el cual usted podra modificar, 
                    recuerde que es muy importante validar la cuenta de mail ya que esta sera utilizada para recibir notificaciones o 
                    nuevas facturas realizadas.</p>
                <?php if (!Yii::$app->user->isguest) { ?>
                    <p><?= Html::a('Mis Datos', ['datos'], ['class' => 'btn btn-default', 'name' => 'datos-button']); ?></p>
                <?php } ?>                
            </div>
            <div class="col-lg-4">
                <h2>Mis Facturas</h2>

                <p>Esta seccion muestra las facturas que le realizo su proveedor, esta seccion muestra las facturas que aun no ha impreso, 
                    puede imprimirlas individualmente o imprimir masivamente, si no encuentra alguna factura utilice los filtros sino comuniquese con su proveedor</p>

                <?php if (!Yii::$app->user->isguest) { ?>
                    <p><?= Html::a('Mis Facturas', ['facturasenc/index'], ['class' => 'btn btn-default', 'name' => 'facturas-button']); ?></p>
                <?php } ?>
            </div>
            <div class="col-lg-4">
                <h2>Empresas</h2>

                <p>Si usted ya tiene contratado el servicio de Factura Electronica con Airtech SA y 
                    quiere visualizar su consola debe dirigirse a su consola haciendo click en el siguiente boton.
                </p>

                <p><a class="btn btn-default" href="http://empresas.e-facturas.com.ar">Empresas &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
