<?php
namespace backend\controllers;

use yii\helpers\Url;
use Yii;
use yii\web\Controller;
use backend\models\LoginForm;
use backend\models\SignupForm;
use backend\models\User;
use backend\models\ModeloFactura;
use backend\models\Mails;
use backend\models\UpdateForm;
use backend\models\Tiporesponsablefe;
use backend\models\Conceptosfe;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\Empresas;
use backend\models\EmpresasAdmin;
use backend\models\MensajesEmpresasSearch;
use backend\models\EstadosConfiguracionFe;
use backend\models\PuntosventaSearch;
use backend\models\PuntosventaEmpresas;
use backend\models\VistasAudita;
use backend\models\ComprobantesEnvioSearch;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use backend\models\Provinciasfe;
use yii\helpers\Json;
/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'ConfirmAcount', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                     'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {        
    	
    	$estados = null;
    	$mensajes_empresa = null;
    	
    	if (!Yii::$app->user->isGuest) {
    		
			return $this->redirect(['state-index']); 
    	}
    	
        return $this->render('index', [
        		'estados' => $estados,
        		'mensajes_empresa' => $mensajes_empresa
			]
		);
    }

    
    public function actionStateIndex()
    {
    	$this->isGuestGoHome();
    	$this->clearVarSession();
    	
    	$estados = null;
    	$mensajes_empresa = null;

    	$ESTADO_SI = EstadosConfiguracionFe::$ESTADO_OK;
    	$ESTADO_NO = EstadosConfiguracionFe::$ESTADO_NULL;
    
   		$estados = EstadosConfiguracionFe::getEstadosArray();
   		$estados = EstadosConfiguracionFe::updateEstados($estados);
    
   		$VISTA = 'site/index';
   		$mensajes_empresa = MensajesEmpresasSearch::getMensajesArray($VISTA);
//     			    	print_r($mensajes_empresa);
//     			    	exit;
    	 
    	return $this->render('stateIndex', [
    			'estados' => $estados,
    			'mensajes_empresa' => $mensajes_empresa,
    			'ESTADO_SI' => $ESTADO_SI,
    			'ESTADO_NO' => $ESTADO_NO,
    	]
    	);
    }
    

    
    public function actionSignup()
    {
    	$this->isUserGoHome();
    	
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
        	$user = $model->signup();

        	// el cuit ya esta en empresas y esa empresa ya tiene usuario
        	if ($user === false) {
        		Yii::$app->getSession()->setFlash('danger', 
        			'<b>' . 'Atención:' . '</b>' . ' el CUIT ' . '<b>' . $model->cuit . '</b>' . ' ya se encuentra registrado. Pongase en contacto con el Administrador.');
        		
        		return $this->render('signup', ['model' => $model]);
        	}
        	
        	// el usuario y/o la empresa se guardaron ok
            else if ($user) {
            	
            	// se genera el modelo de factura por defecto para la empresa.
            	$EMPRESA = Empresas::getEmpresaByCuit($model->cuit);
            	ModeloFactura::generateDefaultModeloFactura($EMPRESA->empresaid);
            	
            	// se guarda el email del usuario en la tabla mails para las notificaciones
            	$email = new Mails();
            	$email->empresaid = $EMPRESA->empresaid;
            	$email->nombre = $model->username;
            	$email->mail = $model->email;
            	$email->save();
            	
                if ($model->sendEmail()) {

					Yii::$app->getSession()->setFlash('success', 
			        	'<b>' . $model->username . '</b>'
			        	. ' verifique su casilla de correo '
			        	. '<b>' . $model->email . '</b>'		
			        	. ' para activar su cuenta.');

			        // se limpia el formulario
			        $model = new SignupForm();
			        
			        return $this->render('signup', ['model' => $model]);

            	} 
                else {
                    Yii::$app->getSession()->setFlash('danger', 
                    		'Disculpe, no pudimos enviar el email a su casilla de correo ' 
                    		. '<b>' . $model->email . '</b>'
                    		. '. Pongase en contacto con el Administrador.');
                }                
            } 
            else {
            	Yii::$app->getSession()->setFlash('danger', 'Disculpe, no pudimos crear su cuenta. Vuelva a intentarlo.');
            }
        }


        return $this->render('signup', ['model' => $model]);
    
    }

    
    
//     public function actionDatos()
//     {   
//     	$this->isGuestGoHome();
    	
//         $model = new UpdateForm();
//         $model->empresaid = Yii::$app->user->identity->empresaid;

        
// //         $model = Empresas::getEmpresa();
// //         print_r($model);
// //         exit();
        
//         if ($model->load(Yii::$app->request->post())) {
//             if ($user = $model->update()) {
// //                 Yii::$app->getSession()->setFlash('success', 'Se realizaron los cambios correctamente.');
//                 Yii::$app->session->setFlash('success', 'Se realizaron los cambios correctamente.');

//                 $model->passwordold = '';
//                 return $this->render('datos', [
//                     'model' => $model,
//                     'responsables' => Tiporesponsablefe::find()->all(),
//                     'prestadores' => Conceptosfe::find()->all(),
// 					'provincias' => Provinciasfe::find()->all(),
//                 ]); 
//             } else {
//                 Yii::$app->session->setFlash('danger', 'Disculpe, No se pudo realizar la modificacion intente mas tarde.');
//             }
//         }
        
//         $model->inicioact = explode(' ',$model->inicioact)[0];
//         return $this->render('datos', [
//             'model' => $model,
//             'responsables' => Tiporesponsablefe::find()->all(),
//             'prestadores' => Conceptosfe::find()->all(),
// 			'provincias' => Provinciasfe::find()->all(),
//         ]); 
//     }

    
    public function actionDatos()
    {
    	$this->isGuestGoHome();
    	 
    	$pv1 = PuntosventaSearch::getPuntosVentaIdEmpresaLimit1();
    	$puntosVenta = PuntosventaSearch::getArrayPuntosVentaEmpresa();
    	$model = PuntosventaEmpresas::getPuntoVentaEmpresaById($pv1['puntoventaid']);
    	 
    	 
    	if ($model === null) {
    		return $this->render('siteError', ['mensaje' => 'Error al definir punto de venta empresa ' . $pv1['puntoventaid']]);
    	}
    	 
    	
    	$post = Yii::$app->request->post();
    	if ($model->load($post)) {

    		if (User::isPasswordCorrect($post['PuntosventaEmpresas']['passwordold'])) {
    			
	    		$pv_modificado = PuntosventaSearch::getPuntoVentaEmpresaById($model->puntoventaid);
    		
	    		if ($model->updatePVE()) {
	    			Yii::$app->session->setFlash('success', 'El punto de venta ' . '<b>' .$pv_modificado->puntoventa . '</b>' . ' se actualizó correctamente.');
	    
	    			$model->passwordold = '';
	    			return $this->render('datos', [
	    					'model' => $model,
	    					'pv1' => $pv1,
	    					'puntosVenta' => $puntosVenta,
	    					'responsables' => Tiporesponsablefe::find()->all(),
	    					'prestadores' => Conceptosfe::find()->all(),
	    					'provincias' => Provinciasfe::find()->all(),
	    			]);
	    		} 
	    		else {
	    			$pid = '';
	    			if ($pv_modificado !== null) {
	    				$pid = $pv_modificado->puntoventa;
	    			}
	    			Yii::$app->session->setFlash('danger', 'Disculpe, No se pudo realizar la modificación en el punto de venta ' . '<b>' . $pid . '</b>');
	    		}

    		}	    		
    		else {
    			Yii::$app->session->setFlash('danger', 'El password ingresado no es correcto.');
    		}
    	}
    	
    	
    	return $this->render('datos', [
    			'model' => $model,
    			'pv1' => $pv1,
    			'puntosVenta' => $puntosVenta,
    			'responsables' => Tiporesponsablefe::find()->all(),
    			'prestadores' => Conceptosfe::find()->all(),
    			'provincias' => Provinciasfe::find()->all(),
    	]);
	    	
    }    
    
    public function actionModeloFactura()
    {         
    	$this->isGuestGoHome();
    	
        $model = new ModeloFactura();
        
        if ($model->load(Yii::$app->request->post())) {

			$modelo_datos = Yii::$app->request->post()['ModeloFactura'];


            $model->puntoventaid = $modelo_datos['puntoventaid'];
            $model->passwordold = $modelo_datos['passwordold'];
            $model->modelo = $modelo_datos['modelo'];
            $model->file = $modelo_datos['file'];
            
            $model->file = UploadedFile::getInstance($model, 'file');


//		if (Yii::$app->user->identity->empresaid == 41) {
//			print_r($modelo_datos);	
//			echo '<br><br>';
//			print_r($model);	
//	
//			exit();
//		}

            
            $pv = PuntosventaSearch::getPuntoVentaEmpresaById($model->puntoventaid);
            
            if ($user = $model->update()) {
            	
            	$model->resizeImage();
                Yii::$app->getSession()->setFlash('success', 'El punto de venta <b>' . $pv->puntoventa . '</b> se actualizó correctamente.');

                $model->passwordold = '';
                //return $this->redirect(['modelo-factura'], ['model' => $model]); 

            } else if ($user === false){
                Yii::$app->getSession()->setFlash('danger', 'Disculpe. No se pudo modificar el punto de venta <b>' . $pv->puntoventa . '</b>, intente nuevamente.');
            }
        }

        if ($model->file == null)
        	$model->file = ModeloFactura::IMAGEN_ALTERNATIVA;

        
        $puntosVenta = PuntosventaSearch::getArrayPuntosVentaEmpresa();
         
        $pv1 = PuntosventaSearch::getPuntosVentaIdEmpresaLimit1();
        
        if ($pv1 === null) {
        	return $this->render('siteError', ['mensaje' => 'Debe definir un punto de venta']);
        }
        
        return $this->render('modeloFactura', [
            'model' => $model,
        	'puntosVenta' => $puntosVenta,
        	'pv1' => $pv1
        ]); 
    }
    
    public function actionGetModeloFactura($pvid)
    {
    	$puntoVenta = ModeloFactura::getModeloFacturaJoinPuntoVenta($pvid);
    	return Json::encode($puntoVenta);
    }
    
    public function actionGetDatosEmpresa($pvid)
    {
    	$puntoVenta = PuntosventaEmpresas::getDatosEmpresaJoinPuntoVenta($pvid);
    	return Json::encode($puntoVenta);
    }
    
    public function actionGetCountErrores()
    {
        $errores = '0';

        if (!Yii::$app->user->isGuest) {
            $errores = ComprobantesEnvioSearch::getCountErroresFeEmpresa();
        }
    	
//     	$errores = ['10'=>'5'];
    	return Json::encode($errores);
    }
    
    
    public function actionLogin()
    {
    	$this->isUserGoHome();
    	
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        	
        	VistasAudita::saveVistaAudita('Login');
        	
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
    	$this->isGuestGoHome();
    	
    	VistasAudita::saveVistaAudita('Logout');

    	Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
    	//$this->isUserGoHome();
    	
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 
                		'Chequee su casilla de correo'
                		. '<b> ' . $model->email . ' </b>'
                		. 'para nuevas instrucciones.'
                		);

//                 return $this->goHome();
            }
            else {
                Yii::$app->getSession()->setFlash('danger', 'Disculpe, no pudimos resetear su contraseña. Intentelo nuevamente.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionPasswordreset()
    {
        //$this->isUserGoHome();
        
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 
                        'Chequee su casilla de correo'
                        . '<b> ' . $model->email . ' </b>'
                        . 'para nuevas instrucciones.'
                        );

//                 return $this->goHome();
            }
            else {
                Yii::$app->getSession()->setFlash('danger', 'Disculpe, no pudimos resetear su contraseña. Intentelo nuevamente.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }


    public function actionResetPassword($token)
    {
    	$this->isTokenIsNullGoHome($token);
    	$this->isUserGoHome();
    	
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())) {
	        if ($model->validate() && $model->resetPassword()) {
	            Yii::$app->getSession()->setFlash('success', 'Nueva Contraseña actualizada.');
	        }
	        else {
	        	Yii::$app->getSession()->setFlash('danger', 'Disculpe, no pudimos actualizar su contraseña. Intentelo nuevamente.');
	        }

//             return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionConfirmAcount($token)
    {
    	$this->isTokenIsNullGoHome($token);
    	$this->isUserGoHome();
    	
        $model =  User::findByTokenAccount($token);
        
        if ($model) {
        	$model->removePasswordResetToken();
        	$model->activeStatus();
        	$model->save();
        	
        	Yii::$app->getUser()->login($model);
        }

        return $this->goHome();  
    }
    

    /*
     * se borran las variables de sesion que se vayan acumulando
     */
    protected function clearVarSession()
    {
	    if (count($_SESSION) > 50) {
	    	foreach ($_SESSION as $session_name => $session_value) {
	    		if (strlen($session_name) > 20)
	    			unset($_SESSION[$session_name]);
	    	}
	    }
    }
    
    
    
    /*
     * $view -> vista a donde redirigir -> es recomendable pasar 'controller/view' ej. 'site/index'
     * $title -> titulo de la ventana modal 
     * $msg -> mensaje secundario de la ventana modal
     * $color -> se pasa una clase para el color de la ventana -> puede ser [success, danger, info, warning]
     * $spinner -> clase  de spinner -> puede ser [spinner, circle-o-notch, cog, gear, refresh]
     */
    
 
    
//     public function actionRedirect($view=null, $title=null, $msg=null, $color=null, $spinner=null)
//     {
    public function actionRedirect($params=null)
    {
    	$params = Yii::$app->session->get($params);
    	
    	if ($params === null || !isset($params['view'])) {
    		return $this->redirect(['site/index']);
    	}
    	
    	return $this->render('redirect', ['params' => $params]);
    }
    
}
