<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mails */

$this->title = 'Agregar Email';
$this->params['breadcrumbs'][] = ['label' => 'Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-create">

    <h4><?= Html::encode($this->title) ?></h4>
    
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
			echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
			}
	?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
