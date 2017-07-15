<?php
use backend\assets\FacturaAsset;
use frontend\models\Empresas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

FacturaAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400,700,600,300" rel="stylesheet" type="text/css">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura</title>
    <?php $this->head() ?>
</head>
<body class="body page-index clearfix" onload="check_barcode($BARCODE_JS)">

<!-- --------------------- BOTON IMPRIMIR ---------------- -->
<button id="btn" class="botonimagen" 
onmouseover=msgShow(); onmouseout=msgHide(); onclick=imprimir(); 
style="background: url('<?= Url::base('http') . '/images/print.png';?>') no-repeat 0 0"></button>

<div id="msg" class="mensajeprint">
Para agregar imágenes en la impresión seleccione <b> Más opciones > Gráficos de fondo.</b>
</div>
<!-- --------------------- BOTON IMPRIMIR ---------------- -->

<?php $this->beginBody() ?>
	
    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>