<?php

use yii\helpers\Url;

?>
<meta http-equiv="refresh" content="5;url=<?= Url::to(['index']) ?>" />

<div class="site-error">
    <div class="alert alert-danger" role="alert">
		<div style="width:95%; margin:auto; text-align: left;">
			<br>
				<h4>
					<span class='glyphicon glyphicon-remove'></span>
					No tiene autorización para ver este comprobante.
				</h4>
			<br>
		</div>
	</div>
</div>
