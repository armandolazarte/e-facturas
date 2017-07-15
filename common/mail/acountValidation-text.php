<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-acount', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Haga clic en el siguiente enlace para confirmar su cuenta:

<?= $resetLink ?>
