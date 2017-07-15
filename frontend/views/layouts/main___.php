<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Consola Factura Electronica',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
               ['label' => 'Home', 'url' => ['/site/index']],           
           ];
           if (Yii::$app->user->isGuest) {
               $menuItems[] = ['label' => 'Registrarse', 'url' => ['/site/signup']];
               $menuItems[] = ['label' => 'Ingresar', 'url' => ['/site/login']];
           } else {
               $menuItems[] = [
                   'label' => 'Mis datos',
                   'url' => ['/site/datos']                   
               ];
               $menuItems[] = [
                   'label' => 'Mis facturas',
                   'url' => ['/facturasenc/index']                   
               ];
               $menuItems[] = [
                   'label' => 'Salir (' . Yii::$app->user->identity->username . ')',
                   'url' => ['/site/logout'],
                   'linkOptions' => ['data-method' => 'post']                   
               ];               
           }
           echo Nav::widget([
               'options' => ['class' => 'navbar-nav navbar-right'],
               'items' => $menuItems,
           ]);
            NavBar::end();
        ?>

        <div class="container">
        <?php // Breadcrumbs::widget([
            //'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        //]) ?>
        <?= Alert::widget() ?> 
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Airtech SA (<?= date('Y') ?>)</p>
        <!--     <p class="pull-right"><?php //echo Yii::powered()?></p> -->
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
