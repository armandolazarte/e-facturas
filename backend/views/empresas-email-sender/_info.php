
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
<button class="btn btn-default active" title="�Qu� es esto?" data-toggle="collapse" 
data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
<span class="glyphicon glyphicon-question-sign"></span>&nbsp;�Qu� es esto?
</button>
</div>
<div class="collapse" id="collapseExample">
<br>
<div class="alert alert-default breadcrumb">
<div align="left">
  <b>Configure una cuenta de Email para notificar a sus clientes y poder enviarles las facturas.</b> 
  <br><br>
  <b>ATENCI�N: solo disponible para cuentas de GMAIL.</b> 
  <br>  
  Una vez que guarde los datos, se le enviar� un correo con un link al cual deber� acceder para validar su cuenta.
  <br><br>
  <small>
  <b><i>* En caso de que prefiera no indicar un correo para notificaciones, las facturas ser�n enviadas desde el email de Airtech.</i>
  </b>
  </small>
  <br><br>
  
  <b>&#8226; Nombre:</b> El nombre que ve el cliente al recibir la factura<br>
  <b>&#8226; Email:</b> El correo con el cual se env�an las notificaciones a los clientes<br>
  <b>&#8226; Password Email:</b> La contrase�a de su correo electr�nico<br>
  <b>&#8226; Servidor SMPT:</b> Configure el servidor SMTP de su correo electr�nico<br>
  <b>&#8226; Puerto SMPT:</b> Configure el puerto de comunicaci�n de su servidor SMTP<br>
  <?php if ($view) { ?>
  <b>&#8226; Estado:</b> Indica si su correo electr�nico ha sido validado<br>
  <?php } else { ?>
  <b>&#8226; Password Actual:</b> La contrase�a que utiliz� para ingresar en este sitio<br>
  <?php } ?>      

</div>
</div>
</div>  
<hr>  
