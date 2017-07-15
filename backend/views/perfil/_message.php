
<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
	echo '<div class="alert alert-' . $key . ' fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		 . $message . '</div>';
	}
?>