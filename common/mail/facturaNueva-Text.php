<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['facturasenc/view','id' => $factura->facturaid]);
?>
Hola <?= $user->username ?>,

Usted tiene una factura para imprimir:
<?php echo $factura->comprobanteid.' '.$factura->comprobantenro; ?>
<?= $resetLink ?>