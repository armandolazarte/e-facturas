<?php 
use yii\helpers\Html;
?>


<div class="site-error">
    <div class="alert alert-danger" role="alert">
		<div style="width:80%; margin:auto; text-align: center;">
					<span class='glyphicon glyphicon-remove'></span>
					<?php 
					if ($mensaje) 
						echo Html::encode($mensaje);	
					?>
		</div>
	</div>
</div>

<nav>
  <ul class="pager">
    <li>
    	<a href="javascript:window.close();">
	    Cerrar Pestaña
      	</a>
    </li>
  </ul>
</nav>