
<?php 

if (Yii::$app->session->getAllFlashes()) {
  foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
    }
  Yii::$app->getSession()->removeAllFlashes();
}
else {
  echo '<br><br>';
  
}

?>

<div align="center" style="font-size:24px">Email Notificaciones 
<button class="btn btn-default active" title="¿Qué es esto?" data-toggle="collapse" 
data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
<span class="glyphicon glyphicon-question-sign"></span>&nbsp;¿Qué es esto?
</button>
</div>
<div class="collapse" id="collapseExample">
<br>
<div class="alert alert-default breadcrumb">
<div align="left">
  <b>Configure una cuenta de Email para notificar a sus clientes y poder enviarles las facturas.</b> 
  <br><br>
  <b>ATENCIÓN: solo disponible para cuentas de GMAIL.</b> 
  <br>  
  Una vez que guarde los datos, se le enviará un correo con un link al cual deberá acceder para validar su cuenta.
  <br><br>
  <small>
  <b><i>* En caso de que prefiera no indicar un correo para notificaciones, las facturas serán enviadas desde el email de Airtech.</i>
  </b>
  </small>
  <br><br>
  
  <b>&#8226; Nombre:</b> El nombre que ve el cliente al recibir la factura<br>
  <b>&#8226; Email:</b> El correo con el cual se envían las notificaciones a los clientes<br>
  <b>&#8226; Password Email:</b> La contraseña de su correo electrónico<br>
  <b>&#8226; Servidor SMPT:</b> Configure el servidor SMTP de su correo electrónico<br>
  <b>&#8226; Puerto SMPT:</b> Configure el puerto de comunicación de su servidor SMTP<br>
  <?php if ($view) { ?>
  <b>&#8226; Estado:</b> Indica si su correo electrónico ha sido validado<br>
  <?php } else { ?>
  <b>&#8226; Password Actual:</b> La contraseña que utilizó para ingresar en este sitio<br>
  <?php } ?>      

</div>
</div>
</div>  
<hr>  
