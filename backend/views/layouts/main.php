<?php
use backend\assets\AppAsset;
use backend\models\Empresas;
use backend\models\EmpresasAdmin;
use common\models\Formato;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

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
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            $nombre = 'Airtech SA';
            if (!Yii::$app->user->isGuest) {
              $nom_emp = Empresas::getForceRazonSocial();
              $nombre = ($nom_emp !== null) ? $nom_emp : $nombre;
              $nombre = (EmpresasAdmin::isAdmin()) ? 'ADMINISTRADOR' : $nombre;
              Yii::$app->session->set('Empresa', $nombre);
            }            
            NavBar::begin([
                'brandLabel' =>  $nombre,
                'brandUrl' => ['/perfil/consola-descripcion/'],
                'id' => 'consola_desc',
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                    'id' => 'consola_descripcion',
                ],
            ]);
            
             $menuItems = [
               ['label' => '<span class="glyphicon glyphicon-home"></span> Home', 
                  'url' => ['/site/index']],           
           ];
            if (Yii::$app->user->isGuest) {
               $menuItems[] = ['label' => '<span class="glyphicon glyphicon-check"></span> Registrarse', 'url' => ['/site/signup']];
               $menuItems[] = ['label' => '<span class="glyphicon glyphicon-log-in"></span> Ingresar', 'url' => ['/site/login']];
           } else {
            
           if (EmpresasAdmin::isAdmin()) {

              $menuItems[] = [
                  'label' => '<span class="glyphicon glyphicon-th-large"></span> Admin',
                  'items' => [
                      ['label' => '<span class="glyphicon glyphicon-comment"></span> Mensajes Empresas', 'url' => ['/mensajes-empresas/index']],
                      ['label' => '<span class="glyphicon glyphicon-play"></span> Puntos y Estados FE', 'url' => ['/estados-configuracion-fe/index']],
                      ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Vistas', 'url' => ['/vistas/index']],
                      ['label' => '<span class="glyphicon glyphicon-time"></span> Vistas Audita', 'url' => ['/vistas-audita/index']],
                      ['label' => '<span class="glyphicon glyphicon-barcode"></span> Facturas Debugger', 'url' => ['/facturas-debugger/index']],
                  ]
                   
              ];              
              
              $params = ['view' => 'empresas/index', 'title' => 'cargando datos empresas . . .','spinner' => 'spinner'];
              $var_session = Formato::generateRandomLetters();
              Yii::$app->session->set($var_session, $params);

              $params = ['view' => 'comprobantes-envio/index', 'title' => 'buscando errores FE empresas . . .','spinner' => 'spinner','color' => 'danger'];
              $var_session_err = Formato::generateRandomLetters();
              Yii::$app->session->set($var_session_err, $params);              
              
              $menuItems[] = [
                  'label' => '<span class="glyphicon glyphicon-tower"></span> Empresas',
                  'items' => [
                      ['label' => '<span class="glyphicon glyphicon-file"></span> Facturas CAE', 'url' => ['site/redirect', 'params' => $var_session]],
                      ['label' => '<span class="glyphicon glyphicon-user"></span> Usuarios', 'url' => ['/empresauseradmin/index']],                      
                      ['label' => '<span class="glyphicon glyphicon-remove"></span> Errores FE', 'url' => ['site/redirect', 'params' => $var_session_err]],
                  
                  ]
                   
              ];
            }
            
            if (EmpresasAdmin::isEmpresaAdmin() && !EmpresasAdmin::isAdmin()) {
              $params = ['view' => 'empresas/index', 'title' => 'cargando datos empresas . . .', 'spinner' => 'spinner'];
              $var_session = Formato::generateRandomLetters();
              Yii::$app->session->set($var_session, $params);
            
              $menuItems[] = [
                  'label' => '<span class="glyphicon glyphicon-file"></span> Facturas CAE',
                  'url' => ['site/redirect', 'params' => $var_session]
              ];
            
            }
            
            
            
               $menuItems[] = [
                  'label' => '<span class="glyphicon glyphicon-cog"></span> Configuración',
                  'items' => [
                      ['label' =>  '<span class="glyphicon glyphicon-check"></span> Mis Datos','url' => ['/site/datos']],
//                        '<li class="divider"></li>',
//                        '<li class="dropdown-header">Dropdown Header</li>',
                      ['label' => '<span class="glyphicon glyphicon-picture"></span> Modelo Factura', 'url' => ['/site/modelo-factura']],
                      ['label' => '<span class="glyphicon glyphicon-random"></span> Puntos de Venta', 'url' => ['/puntosventa/index']],
                      ['label' => '<span class="glyphicon glyphicon-tag"></span> Servicios', 'url' => ['/configuracionservicios/index']],
                      ['label' => '<span class="glyphicon glyphicon-envelope"></span> Emails', 'url' => ['/mails/index']]
                  ]

               ];
               $menuItems[] = [
                   'label' => '<span class="glyphicon glyphicon-user"></span> Receptores',
                   'url' => ['/receptores/index']                   
               ];
               $menuItems[] = [
					'label' => '<span class="glyphicon glyphicon-remove"></span> Errores',
					'url' => ['/comprobantes-envio/errores'],
					'linkOptions' => ['id' => 'labelErroresFE'],
               ];               
               $menuItems[] = [
                   'label' => '<span class="glyphicon glyphicon-file"></span> Mis facturas',
                   'url' => ['/facturasenc/index']                   
               ];
                $menuItems[] = [
                    'label' => '<span class="glyphicon glyphicon-tasks"></span> Opciones',
                    'items' => [
            ['label' => '<span class="glyphicon glyphicon-user"></span> Perfil', 'url' => ['/perfil/email']],
            ['label' => '<span class="glyphicon glyphicon-envelope"></span> Notificaciones', 'url' => ['/empresas-email-sender/index']],                      
            '<li class="divider"></li>',
 //             '<li class="dropdown-header">Dropdown Header</li>',
                        ['label' => '<span class="glyphicon glyphicon-log-out"></span> Salir (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                      ]
                    ]                   
                ];               


               
           }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Airtech SA (<?= date('Y') ?>)</p>
        <!--     <p class="pull-right"><?php //echo Yii::powered()?></p> -->
        <?php
        if (!Yii::$app->user->isGuest) {
          echo '<div class="pull-right">
          <button id="btnErroresFE" style="display:none">error</button>
          </div>';
        }
        ?>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

