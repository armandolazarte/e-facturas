<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use common\models\User;
use common\models\Formato;
use common\models\Email;
use backend\models\FacturasForm;
use backend\models\ModeloFactura;
use backend\models\ModeloFacturas;
use backend\models\Tipocomprobantefe;
use backend\models\Formaspagofe;
use backend\models\Provinciasfe;
use backend\models\Configfacturasindex;
use backend\models\EmpresaUser;
use backend\models\FacturasVistaPublica;
use backend\models\Mails;
use backend\models\MailsSearch;
use backend\models\Receptoresemails;
use backend\models\EmpresasEmailSender;
use backend\models\PuntosventaEmpresas;
use backend\models\PuntosventaSearch;
use backend\models\VistasAudita;
use backend\models\EmpresasAdmin;
use backend\models\MensajesNotificacionFacturas;
use backend\models\FacturasMensajesNotificacion;
use backend\models\ConfigNotificacionFactura;
use frontend\models\Facturasenc;
use frontend\models\Facturastributo;
use frontend\models\Facturasiva;
use frontend\models\Facturasitem;
use frontend\models\Facturaspie;
use frontend\models\Facturasnotas;
use frontend\models\Empresas;
use frontend\models\Puntosventa;
use frontend\models\Tiporesponsablefe;
use frontend\models\Receptores;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\models\FacturasDebugger;

/**
 * FacturasencController implements the CRUD actions for Facturasenc model.
 */
class FacturasencController extends Controller
{

/*    private $facturasenc;

    function __construct()
    {
        $this->facturasenc = new Singleton();
    }*/

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Facturasenc models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isGuestGoHome();
    	
    	VistasAudita::saveVistaAudita('Mis facturas');
    	
    	ConfigNotificacionFactura::createConfigEmpresaDefault();
    	
        $comprobantes = Tipocomprobantefe::find()->all();
       
        // configutacion de filtros por defecto para la vista index
        $CONFIG = Configfacturasindex::find()->where(['empresaid'=>Yii::$app->user->identity->empresaid])->one();
        
        $CONFIG_notificacion_factura = ConfigNotificacionFactura::getConfigEmpresa();
        
        if($CONFIG == NULL) {
        	$CONFIG = Configfacturasindex::find()->where(['empresaid'=>-1])->one();
        }

//		$ORDEN = ['comprobantenro' => SORT_DESC];
// 		SORT_DESC = 3   ---   SORT_ASC = 4  

        $ORDEN = [
			$CONFIG->orden1_campo => (int) $CONFIG->orden1_tipo,
			$CONFIG->orden2_campo => (int) $CONFIG->orden2_tipo,
		];        	


        $search = new FacturasForm();
        #Chequea si se ingresaron datos para filtrar
        if ($search->load(Yii::$app->request->post())) {
            $query = Facturasenc::find()
                            ->joinWith('facturaspies')
                            ->joinWith('facturasmensajesnotificacion')
				          //->leftJoin('facturas_mensajes_notificacion', '`facturas_mensajes_notificacion`.`facturaid` = `facturasenc`.`facturaid`')
                            ->joinWith('receptor')
                            ->joinWith('puntoventa0')
                            ->where('facturasenc.empresaid = :empresaid and ifnull(cae,-1) > :cae',['empresaid'=>Yii::$app->user->identity->empresaid,'cae' => 0])
                            ->groupBy(['empresaid', 'receptorid', 'puntoventa', 'comprobanteid', 'comprobantenro', 'letra'])
                            ->orderBy($ORDEN);
            
            if ($search->fchdde) {
                $query->andWhere('fechafactura >= :fchdde',['fchdde'=>Formato::fechaDataPickerToSql($search->fchdde)]);
            }
            if ($search->fchhta) {
                $query->andWhere('fechafactura <= :fchhta',['fchhta'=>Formato::fechaDataPickerToSql($search->fchhta)]);
            }
            if ($search->puntoventa) {
                $query->andWhere('puntosventa.puntoventa like :puntoventa',['puntoventa'=>'%'.$search->puntoventa.'%']);
            }
            if ($search->comprobante != 0) {
                $query->andWhere('facturasenc.comprobanteid = :comprobante',['comprobante'=> $search->comprobante]);
            }
            //if ($search->receptor) {
            //    $query->orWhere('receptores.nombre like :nombre or receptores.direccion like :direccion',['nombre'=>'%'.$search->receptor.'%', 'direccion'=>'%'.$search->receptor.'%']);
            //}
            if ($search->receptor) {
            	$query->andWhere('facturasenc.nombre like :nombre or facturasenc.direccion like :direccion or facturasenc.clienteid = :clienteid',['nombre'=>'%'.$search->receptor.'%', 'direccion'=>'%'.$search->receptor.'%', 'clienteid'=>$search->receptor]);
            }
            if ($search->nrodde) {
                $query->andWhere('comprobantenro >= :nrodde',['nrodde'=>$search->nrodde]);
            }
            if ($search->nrohta) {
                $query->andWhere('comprobantenro <= :nrohta',['nrohta'=>$search->nrohta]);
            }
            if ($search->notificada != -1) {
                $query->andWhere(['notificada'=>$search->notificada]);
            }
            if ($search->impresacli != -1) {
                $query->andWhere(['impresacliente'=>$search->impresacli]);
            }
            if ($search->impresa != -1) {
                $query->andWhere(['impresaproveedor'=>$search->impresa]);
            }
            // se agrega esta linea para corregir el error al buscar por cliente traia facturas de otras empresas
            $query->andWhere(['facturasenc.empresaid'=>Yii::$app->user->identity->empresaid]);

            #$this->facturasenc->setQueryFactura($query);
            Yii::$app->session->set('QueryFactura',$query);

            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
            		'pagination' => [
            				'pagesize' => -1,
            		],
                    //'sort' => ['defaultOrder' => ['facturaid' => SORT_DESC]],
                ]);
            
//             print_r($query->all());
//             exit();

            
            return $this->render('index', [
            		'CONFIG' => $CONFIG,
                    'ALERT_REPLYTO' => false,
            		'CONFIG_notificacion_factura' => $CONFIG_notificacion_factura,
            		'dataProvider' => $dataProvider,#'model'=>$model,
                'comprobantes' => $comprobantes,
                'search' => $search,
            ]);
        }
        else {
            #Si no se ingreso ningun filtro entonces trae las facturas no impresas

            $query = Facturasenc::find()
                        ->joinWith('facturaspies')
                        ->joinWith('receptor')
                        ->joinWith('puntoventa0')
                        ->where('facturasenc.empresaid = :empresaid and ifnull(cae,-1) > :cae',['empresaid'=>Yii::$app->user->identity->empresaid,'cae' => 0])
//                         ->andWhere(['impresaproveedor'=>0])
                        ->andWhere('fechafactura >= :fchdde',['fchdde'=>date('Ymd',strtotime($CONFIG->fchdde*(-1) ."day"))])
                        ->andWhere('fechafactura <= :fchhta',['fchhta'=>date('Ymd',strtotime($CONFIG->fchhta ."day"))])
                        ->groupBy(['empresaid', 'receptorid', 'puntoventa', 'comprobanteid', 'comprobantenro', 'letra'])
                        ->orderBy($ORDEN);

			if ($CONFIG->mostrar_impresas == 0) {
            	$query->andWhere(['impresaproveedor'=> 0]);
			}                        
                        
            Yii::$app->session->set('QueryFactura',$query);
            

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            		'pagination' => [
            				'pagesize' => $CONFIG->pagesize,
            		],
                //'sort' => ['defaultOrder' => ['facturaid' => SORT_DESC]],
            ]);

            if ($CONFIG_notificacion_factura->alert_replyto_visto < 10) {
                $CONFIG_notificacion_factura->alert_replyto_visto = $CONFIG_notificacion_factura->alert_replyto_visto + 1;
                $CONFIG_notificacion_factura->save();
            }

            return $this->render('index', [
            		'CONFIG' => $CONFIG,
                    'ALERT_REPLYTO' => true,
            		'CONFIG_notificacion_factura' => $CONFIG_notificacion_factura,
                'dataProvider' => $dataProvider,#'model'=>$model,
                'comprobantes' => $comprobantes,
                'search' => $search,
            ]);         
        }        
    }



    public function actionNotificar($id = -1)
    {
    	$this->isGuestGoHome();
    	
    	//VistasAudita::saveVistaAudita('Notificar factura');
    	
    	$EMPRESA_ID = Yii::$app->user->identity->empresaid;

        $arrayEmailsReplyTo = MailsSearch::getSingleArrayMailsByEmpresa($EMPRESA_ID);
    	
        /*--------------------------------------------------------------------------*/
        /*--------------            PROVISORIO                             ---------*/
        /*--------------------------------------------------------------------------*/
        //$empresas_habilitadas = [92, 50, 41, 63];
        //if (!in_array($EMPRESA_ID, $empresas_habilitadas))  {
        //    $mensaje = 'Estamos teniendo inconvenientes con la notificación de facturas. El servicio se encuentra temporalmente suspendido.';
        //    return $this->redirect(['error', 'mensaje' => $mensaje]);
        //}

        /*--------------------------------------------------------------------------*/
        /*--------------            PROVISORIO                             ---------*/
        /*--------------------------------------------------------------------------*/


    	$EMPRESA = Yii::$app->session->get('Empresa'); 

    	// se obtiene el email de notificaciones de la empresa
    	$EMAIL_EMPRESA = EmpresasEmailSender::getEmailData($EMPRESA_ID);

    	if ($EMAIL_EMPRESA === null) {
    		$EMAIL_EMPRESA = false;
	    	// se obtiene el nombre de la EMPRESA para enviar el correo
	    	if ($EMPRESA == '') {
	    		$EMPRESA = Empresas::find()->where(['empresaid'=>$EMPRESA_ID])->one()->razonsocial;
	    	}
    	}
    	
    	$mensaje_notificacion = Formato::textAreaToHTML(Html::encode(Yii::$app->session->get('MensajeNotificacionFactura')));
    	$pk_facturas = Yii::$app->session->get('QueryFacturaSelect');
    	
    	Yii::$app->session->set('MensajeNotificacionFactura', '');
    	Yii::$app->session->set('QueryFacturaSelect', []);
    	
        if ($id != -1 || count($pk_facturas) == 1) {
        	
        	if ($id == -1) {
        		$id = $pk_facturas[0];
        	}
        	


            $factura = Facturasenc::findOne($id); 
            if ($factura == null)
                return $this->redirect(['index']);
            
            $punto_venta = Puntosventa::find()->where(['puntoventaid'=>$factura->puntoventa])->one()['puntoventa'];
            
            $factura->comprobantenro = Formato::numeroFactura($factura->comprobantenro);
            $nombre = '';
            $email = '';
            $arrayMails = NULL;
            
            // se busca el receptor de la factura
            $receptor = Receptores::find()->where(['receptorid'=>$factura->receptorid])->one();

            $receptor->receptorid = ($receptor->receptorid !== null) ? $receptor->receptorid : -1 ;


            
        	// emails del receptor
        	$arrayMails = Receptoresemails::getArrayMailsByReceptorId($receptor->receptorid);
            	
                
	            // si el usuario no esta registrado o falta un dato
	            // se busca en receptores
            if ($nombre == '')
                $nombre = $receptor->nombre;
            if (!Email::validate($email))
                $email = $receptor->mail;
	        

            // si aun falta algun dato se obtiene de la factura
            if ($nombre == '')
                $nombre = $factura->nombre;
            
            if (!Email::validate($email))
                $email = $factura->email;
           
            $comprobante = Tipocomprobantefe::find()->where(['comprobanteid'=>$factura->comprobanteid])->one();
            $COMPROBANTE = str_replace('FACTURAS', 'FACTURA', $comprobante->descripcion);


            // ============================== Correccion Emails Receptor  ===================================================

            $email = (Email::validate($email)) ? $email : null;            


            if ($email === null) {
                $email = isset($arrayMails[0]) ? $arrayMails[0] : $email;
            }
            

            if (count($arrayMails) == 1) {
                if ($email == $arrayMails[0]) { 
                    $arrayMails = array();
                }
            }

            if (count($arrayMails) > 0 && ($email == null) ) {
                unset($arrayMails[0]); 
                $arrayMails = array_values($arrayMails);
            }

            $clave = -1;
            if (count($arrayMails) > 0) {
                $clave = array_search($email, $arrayMails);
                if ($clave > -1) {
                    unset($arrayMails[$clave]); 
                    $arrayMails = array_values($arrayMails);                    
                }
            }            



            // ============================== Correccion Emails Receptor  ===================================================


			// SE VALIDA EL EMAIL DEL RECEPTOR
            // si no encuentra un email para notificar 
            // envia un correo a la empresa dando aviso
            if (!Email::validate($email) && ($arrayMails == null)) {
            	// arma el link para que la empresa pueda actualizar el receptor (agregar mail)
            	$receptorUpdateLink = Url::to(['receptores/update','id' => $receptor->receptorid], true);
            	
//            	$body = "EL CLIENTE NO POSEE EMAIL <br><br>
//            			<strong>($factura->clienteid)</strong> - $nombre <br><br>
//            			Puede actualizarlo desde el siguiente link: 
//		            	<a href='$receptorUpdateLink'>ACTUALIZAR</a>";

            	// se obtienen los email de la empresa para avisar que el receptor no recibe la factura
//            	$arrayEmails = MailsSearch::getSingleArrayMailsByEmpresa($EMPRESA_ID);

//				$email = Yii::$app->user->identity->email;
            	
//            	Email::sendMultiple($EMPRESA, $email, 'FALTA EMAIL', $body, $arrayEmails);
            	
                return $this->render('notificadas', [
                		'masiva' => NULL,
                		'ENVIADO' => false,
                		'arrayMails' => null,
                		'factura' => $factura,
                		'COMPROBANTE' => $COMPROBANTE,
                		'nombre' => $nombre, 
                		'email' => "Puede actualizarlo desde el siguiente link: <a href='$receptorUpdateLink'><font color='#A52A2A'>ACTUALIZAR EMAIL</font></a>"
                		]
                	);
            }
			else {
				// TODO OK
				// SE NOTIFICA AL CLIENTE

				
				/**
				 * SE GENERA EL hash PARA LA VISTA PUBLICA DE LA FACTURA
				 * 		busca en la tabla FacturasVistaPublica el hash asociado al id factura
				 * 		si no lo encuentra crea uno y lo devuelve.
				 * 
				 * 		FacturasVistaPublica::getKeyView($id)
				 */ 
				$hash = FacturasVistaPublica::getKeyView($id);
				
                $facturaLink = str_replace('empresas.e-facturas', 'e-facturas', Url::to(['facturasenc/view','id' => $factura->facturaid], true));
	            //$facturaLink = str_replace('backend', 'frontend', Url::to(['facturasenc/view','id' => $factura->facturaid], true));
	            $facturaLink = $facturaLink . '&key=' . $hash;
	            
	            $cte_nro = $COMPROBANTE . ' ' . $factura->comprobantenro;

	            $body = Email::bodyTemplate($nombre, $cte_nro, $facturaLink, $punto_venta, $mensaje_notificacion);

	            
	            if ($EMAIL_EMPRESA) {
		            Email::sendMultipleWithTransport($EMAIL_EMPRESA->nombre, $email, 'Nueva Factura', $body, $arrayMails, $EMAIL_EMPRESA->email, $EMAIL_EMPRESA->password, $EMAIL_EMPRESA->servidor_smpt, $EMAIL_EMPRESA->puerto_smpt, $arrayEmailsReplyTo);
	            }
	            else {
		            Email::sendMultiple($EMPRESA, $email, 'Nueva Factura', $body, $arrayMails, $arrayEmailsReplyTo);
	            }

	            MensajesNotificacionFacturas::saveMensaje($id, $mensaje_notificacion);
	            
	            $factura->notificada = 1;
                
	            $factura->save();

                return $this->render('notificadas', [
                		'masiva' => NULL,
                		'ENVIADO' => true,
                		'arrayMails' => $arrayMails,
                		'factura' => $factura,
                		'COMPROBANTE' => $COMPROBANTE,
                		'nombre' => $nombre, 
                		'email' => $email
                		]
                	);
            }
        } 
		
		// notificacion MASIVA
		else {

			$TOTAL = 0;
			$ENVIADO = false;
			$NOTIFICADAS = 0;
			$ARRAY_FACTURAS_INFO = array();
			$factura = null;
			$COMPROBANTE = null;
			$nombre = null;
			$email = null;
			
            
            $QUERY = Yii::$app->session->get('QueryFactura')->all();
             

// 			print_r($pk_facturas);
// 			exit();

            if (!$QUERY || count($pk_facturas) == 0) {
                $mensaje = 'No existen facturas a notificar con los filtros aplicados previamente, vuelva a intentarlo.';
                if (count($pk_facturas) > 0) {
                    $mensaje = 'Hubo un error. Repita la búsqueda desde Mis Facturas.';
                }
                return $this->redirect(['error', 'mensaje' => $mensaje]);
            }
            

			
            foreach ($QUERY as $key) {
                
                if ($key->facturaid != -1) {

                    if (!in_array($key->facturaid, $pk_facturas)) {
                        continue;
                    }
                    $punto_venta = (isset($key['puntoventa0']['puntoventa'])) ? $key['puntoventa0']['puntoventa'] : '';

                	$factura = Facturasenc::findOne($key->facturaid);
                	if ($factura == null)
                		return $this->redirect(['index']);
                
                	$factura->comprobantenro = Formato::numeroFactura($factura->comprobantenro);
                	$nombre = '';
                	$email = '';
                	$arrayMails = NULL;
                	
                	// se busca el receptor de la factura
                	$receptor = Receptores::find()->where(['receptorid'=>$factura->receptorid])->one();
                	
                	if ($receptor->documentoid !== 99 && strlen($receptor->cuit) >= 8 && ctype_digit($receptor->cuit)) {
                	
                		// emails del receptor
                		$arrayMails = Receptoresemails::getArrayMailsByReceptorId($receptor->receptorid);
                		 
                		// se busca el usuario segun su cuit
                		$user = User::find()->where(['cuit'=>$receptor->cuit])->one();
                		if ($user) {
                			$nombre = $user->username;
                			$email = $user->email;
                		}
                		// si el usuario no esta registrado o falta un dato
                		// se busca en receptores
                		if ($nombre == '')
                			$nombre = $receptor->nombre;
                		if (!Email::validate($email))
                			$email = $receptor->mail;
                		 
                	}
                	
                	// si aun falta algun dato se obtiene de la factura
                	if ($nombre == '')
                		$nombre = $factura->nombre;
                	
                	if (!Email::validate($email))
                		$email = $factura->email;
                	

                	$comprobante = Tipocomprobantefe::find()->where(['comprobanteid'=>$factura->comprobanteid])->one();
                	$COMPROBANTE = str_replace('FACTURAS', 'FACTURA', $comprobante->descripcion);


                    // ============================== Correccion Emails Receptor  ===================================================

                    $email = (Email::validate($email)) ? $email : null;            

                    if ($email === null) {
                        $email = isset($arrayMails[0]) ? $arrayMails[0] : $email;
                    }
                    

                    if (count($arrayMails) == 1) {
                        if ($email == $arrayMails[0]) { 
                            $arrayMails = array();
                        }
                    }

                    if (count($arrayMails) > 0 && ($email == null) ) {
                        unset($arrayMails[0]); 
                        $arrayMails = array_values($arrayMails);
                    }

                    $clave = -1;
                    if (count($arrayMails) > 0) {
                        $clave = array_search($email, $arrayMails);
                        if ($clave > -1) {
                            unset($arrayMails[$clave]); 
                            $arrayMails = array_values($arrayMails);                    
                        }
                    }            

                    // ============================== Correccion Emails Receptor  ===================================================

                	
                	// si no encuentra un email para notificar
                	// envia un correo a la empresa dando aviso
                	if (!Email::validate($email) && ($arrayMails == null)) {
                		$receptorUpdateLink = Url::to(['receptores/update','id' => $receptor->receptorid], true);
                		 
//                		$body = "EL CLIENTE NO POSEE EMAIL <br><br>
//                		<strong>($factura->clienteid)</strong> - $nombre <br><br>
//                		Puede actualizarlo desde el siguiente link:
//                		<a href='$receptorUpdateLink'>ACTUALIZAR</a>";
                		 
//                        $arrayEmails = MailsSearch::getSingleArrayMailsByEmpresa($EMPRESA_ID);
                        
//                        $email = Yii::$app->user->identity->email;

//                        Email::sendMultiple($EMPRESA, $email, 'FALTA EMAIL', $body, $arrayEmails);
                		
                		array_push($ARRAY_FACTURAS_INFO, [false, 'FALTA EMAIL', $COMPROBANTE, $factura->comprobantenro, $factura->clienteid, $nombre . '&nbsp;&nbsp;<a href='.$receptorUpdateLink.' target="_blank" class="btn btn-danger active btn-xs"><span class="glyphicon glyphicon-pencil"></span> Actualizar</a>']);
                		 
                	}
                	else {
                		// SE NOTIFICA AL CLIENTE
                		
                		
//                 		print_r(count($pk_facturas));
//                 		exit();
                		
                		/**
                		 * SE GENERA EL hash PARA LA VISTA PUBLICA DE LA FACTURA
                		 * 		busca en la tabla FacturasVistaPublica el hash asociado al id factura
                		 * 		si no lo encuentra crea uno y lo devuelve.
                		 *
                		 * 		FacturasVistaPublica::getKeyView($id)
                		 */
                		$hash = FacturasVistaPublica::getKeyView($key->facturaid);
                		
                        $facturaLink = str_replace('empresas.e-facturas', 'e-facturas', Url::to(['facturasenc/view','id' => $factura->facturaid], true));
                		//$facturaLink = str_replace('backend', 'frontend', Url::to(['facturasenc/view','id' => $factura->facturaid], true));
                		$facturaLink = $facturaLink . '&key=' . $hash;
                		 
                		 
                		$cte_nro = $COMPROBANTE . ' ' . $factura->comprobantenro;
                		
                		$body = Email::bodyTemplate($nombre, $cte_nro, $facturaLink, $punto_venta, $mensaje_notificacion);

//                 		Email::sendMultiple($EMPRESA, $email, 'Nueva Factura', $body, $arrayMails);
                		
                		
                		if ($EMAIL_EMPRESA) {
                			Email::sendMultipleWithTransport($EMAIL_EMPRESA->nombre, $email, 'Nueva Factura', $body, $arrayMails, $EMAIL_EMPRESA->email, $EMAIL_EMPRESA->password, $EMAIL_EMPRESA->servidor_smpt, $EMAIL_EMPRESA->puerto_smpt, $arrayEmailsReplyTo);
                        }
                		else {
                			Email::sendMultiple($EMPRESA, $email, 'Nueva Factura', $body, $arrayMails, $arrayEmailsReplyTo);
                		}                		
                		
                		MensajesNotificacionFacturas::saveMensaje($key->facturaid, $mensaje_notificacion);
                		
                		$factura->notificada = 1;
                		$factura->save();
                		
                        $emails_notif = '<ul style="list-style-type:disc"><dd><li>'. $email . '</li>';
                        if (isset($arrayMails)) {
                            foreach ($arrayMails as $e) $emails_notif .= ('<li>' . $e . '</li>');
                        }
                        $emails_notif .= '</dd></ul>';
                        
                        $NOTIFICADAS++;
                        array_push($ARRAY_FACTURAS_INFO, [true, 'NOTIFICADA', $COMPROBANTE, $factura->comprobantenro, $factura->clienteid, $nombre, $emails_notif]);
                
                	}
                }
                $TOTAL++;
            }
            
            return $this->render('notificadas', [
	                   'masiva' => [$ARRAY_FACTURAS_INFO, $NOTIFICADAS, $TOTAL],
	                   'factura' => $factura,
            			'ENVIADO' => null,
            			'arrayMails' => null,
	                   'COMPROBANTE' => $COMPROBANTE,
	                   'nombre' => $nombre,
	                   'email' => $email
                   ]
              );
		}

//         return $this->render('notificadas', ['factura' => NULL,'user' => '<h1>NOOOOOO</h1>']);
    }
    
    public function actionSeleccionarFacturas()
    {
        
        $pk_facturas = [];
        if (Yii::$app->request->isAjax) {
            $pk = Yii::$app->request->post('pk');
            if ($pk !== null) {
                $pk_facturas = $pk;
//              	print_r($pk);
            }
        }
        //Yii::$app->session->set('QueryFacturaSelect', array_slice($pk_facturas, 0, 50));
        Yii::$app->session->set('QueryFacturaSelect', $pk_facturas);
    }
    
    public function actionSetMensajeNotificacionFactura()
    {
    
    	$mensaje = "";
    	if (Yii::$app->request->isAjax) {
    		$msj = Yii::$app->request->post('msj');
    		if ($msj !== null) {
    			$mensaje = $msj;
// 				print_r($mensaje);
    		}
    	}
    	Yii::$app->session->set('MensajeNotificacionFactura', $mensaje);
    }    
    

    public function actionSetConfigNotificacionFactura()
    {
    
    	$data = [];
    	if (Yii::$app->request->isAjax) {
    		$config = Yii::$app->request->post('config');
    		if ($config !== null) {
    			$data = $config;
//     			print_r($data[0]);
			    ConfigNotificacionFactura::updateConfigEmpresa($data[0], $data[1]);
    		}
    	}
    }
    
    
    
    public function actionImprimir()
    {
    	$this->isGuestGoHome();

    	$this->layout = "factura";


    	$pk_facturas = Yii::$app->session->get('QueryFacturaSelect');
    	$QUERY = Yii::$app->session->get('QueryFactura')->all();
    	
    	if (!$QUERY || count($pk_facturas) == 0) {
    		$mensaje = 'No existen facturas para los filtros aplicados previamente, vuelva a intentarlo.';
    		if (count($pk_facturas) > 0) {
    			$mensaje = 'Hubo un error. Repita la búsqueda desde Mis Facturas.';
    		}
    		return $this->redirect(['error', 'mensaje' => $mensaje]);
    	}
    	
    	$EMPRESAID = Yii::$app->user->identity->empresaid;
    	
        $facturasimprimir = [];
        foreach ($QUERY as $key) {
        	
        	if (!in_array($key->facturaid, $pk_facturas)) {
        		continue;
        	}
        	
            $model = Facturasenc::find()->where(['facturaid'=>$key->facturaid])->one();

		/*
		echo $model->puntoventa;
		exit();
		*/
	    	$empresa = PuntosventaEmpresas::getPuntoVentaEmpresaById($model->puntoventa);
    		$provincia = Provinciasfe::find()->where(['provinciaid'=>$empresa->provinciaid])->one()->descripcion;
    		$modelo = ModeloFacturas::find()->where(['empresaid'=>$EMPRESAID])->andWhere(['puntoventaid'=>$model->puntoventa])->one();
            $tributo = Facturastributo::find()->where(['facturaid'=>$key->facturaid])->all();
            $iva = Facturasiva::find()->where(['facturaid'=>$key->facturaid])->one();
            $item = Facturasitem::find()->where(['facturaid'=>$key->facturaid])->all();
            $puntoventa = Puntosventa::find()->where(['puntoventaid'=>$model->puntoventa])->one();
            $responsable = Tiporesponsablefe::find()->where(['responsableid'=>$model->responsableid])->one();
            $receptor = Receptores::find()->where(['receptorid'=>$model->receptorid])->one();

            
            $comprobante = Tipocomprobantefe::find()->where(['comprobanteid'=>$model->comprobanteid])->one();
            $puntoventa = Puntosventa::find()->where(['puntoventaid'=>$model->puntoventa])->one();
            $pie = Facturaspie::find()->where(['facturaid'=>$key->facturaid])->one();

		$pie->formapagoid = ($pie->formapagoid == null) ? 2 : $pie->formapagoid;
            $formaspago = Formaspagofe::find()->where(['pagoid'=>$pie->formapagoid])->one();
            $nota = Facturasnotas::find()->where(['facturaid'=>$key->facturaid])->all();

            $letra_factura = ModeloFactura::getLetraFactura($model->letra);
            
            $detalle = [];
            foreach ($item as $i) {
                $detalle[] = ['codigo' => $i->codigo,
                        'descripcion' => $i->descripcion,'cantidad' => $i->cantidad,
                        'preciounitario' => $i->preciounitario,'subtotal' => $i->subtotal,
                ];
            }


            
            $model->impresaproveedor = 1;
            $model->save();

            foreach ($model as $clave => $valor) {
                $model->$clave = utf8_decode($model->$clave);
            }
            
            $facturasimprimir[] = [
            		'id' => $key->facturaid, 
            		'modelo' => $modelo->modelo,
            		'file' => $modelo->file,
            		'letra_factura' => $letra_factura, 
            		'comprobantenro' => $model->comprobantenro,
                    'comprobante_descripcion' => $comprobante->descripcion, 
            		'clienteid' => $model->clienteid, 
            		'nombre' => $model->nombre, 
            		'direccion' => $model->direccion, 
            		'localidad' => $model->localidad, 
            		'fechafactura' => $model->fechafactura, 
            		'puntoventa' => $puntoventa->puntoventa,
            		'razonsocial' => $empresa->razonsocial,
            		'calle' => $empresa->calle,
            		'nro' => $empresa->nro,
            		'piso' => $empresa->piso, 
            		'depto' => $empresa->depto, 
            		'cp' => $empresa->cp, 
            		'nrocuit' => $empresa->nrocuit, 
            		'nroiibb' => $empresa->nroiibb,
            		'inicioact' => $empresa->inicioact, 
            		'responsable' => $responsable->responsable, 
            		'cuit' => $receptor->cuit,
            		'importegravado' => $pie->importegravado, 
            		'importenogravado' => $pie->importenogravado,
            		'importeiva' => $pie->importeiva,
            		'importetributos' => $pie->importetributos,
            		'tributos' => $tributo,
            		'importetotal' => $pie->importetotal,
            		'cae' => $pie->cae,
            		'caevencimiento' => $pie->caevencimiento,
            		'detalle' => $detalle,
            		'provincia' => $provincia,
            		'telefono' => $empresa->telefono,
            		'email' => $empresa->email,
                    'url' => $empresa->url,
            		'localidadEmpresa' => $empresa->localidad,
            		'comprobantecodigo' => $comprobante->codigo,
            		'formapago' => $formaspago->descripcion,
            		'nota' => $nota,
            		'condicion_pago' => $model->condicion_pago,
            		'reparto_frec' => $model->reparto . ' ' . $model->frecuencia,
            		'provinciaid' => $model->provinciaid,
            		'barcode' => $model->barcode,
            ];
        }
        
        return $this->render('imprimir', [
        		'imprimir' => $facturasimprimir,
            	'modelo' => $modelo,
                'empresa' => $empresa,
        	]
        );
    }

    public function actionError($mensaje=null)
    {
    	// $this->isGuestGoHome();
    	 
    	return $this->render('error', ['mensaje' => $mensaje]);
    }
    
    public function actionView($id, $key=false)
    {

        // PROVISORIAMENTE 03/11/2015
        // si recibe un hash se redirecciona al frontend/view 
        if(strlen($key) == 64) {
            //echo "e-facturas.com.ar/index.php?r=facturasenc%2Fview&id=$id&key=$key";
            //exit;
            return $this->redirect("http://e-facturas.com.ar:85/index.php?r=facturasenc%2Fview&id=$id&key=$key");
            
        }

    	$this->isGuestGoHome();
    
    	$this->layout = "factura";
    
    	$user = EmpresaUser::findIdentity(yii::$app->user->id);
    	$model = $this->findModel($id);
//     	$empresa = Empresas::find()->where(['empresaid'=>$model->empresaid])->one();
    	$empresa = PuntosventaEmpresas::getPuntoVentaEmpresaById($model->puntoventa);
    	
        // se comprueba que la empresa tenga sucursal configurada
        // sino muestra un mensaje de error.


//        if (EmpresasAdmin::isAdmin()) {
//            print_r($model);
//            exit();
//        }   

        if ($empresa == null) {
            $mensaje = 'Configure los datos del punto de venta.';
            return $this->redirect(['error', 'mensaje' => $mensaje]);
        }       
        

        //$modelo = ModeloFacturas::find()->where(['empresaid'=>$empresa->empresaid])->andWhere(['puntoventaid'=>$model->puntoventa])->one();

    	$modelo= null;
        
    	$pv = PuntosventaSearch::getPuntoVentaEmpresaById($model->puntoventa);

    	
//     	print_r($modelo);
//     	echo $pv->puntoventa;
//     	echo '<br>';
//     	exit();
    	
    	
        // se comprueba que la empresa tenga un modelo de factura configurado
        // sino muestra un mensaje de error.
        if ($modelo == null) {
            $mensaje = 'Su empresa proveedora no se encuentra registrada en este sitio web.';
            return $this->redirect(['error', 'mensaje' => $mensaje]);
        }
        
        // se busca el receptor de la factura
        $receptor = Receptores::find()->where(['receptorid'=>$model->receptorid])->one();
        
        // si el cliente no presenta dni
        // si el cuit no es valido no lo muestra en la factura
        if ($receptor->documentoid == 99) {
        	if (strlen($receptor->cuit) < 8 || !ctype_digit($receptor->cuit)) {
        		$receptor->cuit = '';
        	}
        }        

    	$pie = Facturaspie::find()->where(['facturaid'=>$id])->one();

        $letra_factura = ModeloFactura::getLetraFactura($model->letra);
       
    	$model->impresaproveedor = 1;
    	$model->save();
    	
    	$factura_debug = FacturasDebugger::find()->one();

        foreach ($model as $clave => $valor) {
            $model->$clave = utf8_decode($model->$clave);
        }

	$pie->formapagoid = ($pie->formapagoid == null) ? 2 : $pie->formapagoid;
    	
    	return $this->render('view', [
    			'factura_debug' => $factura_debug,
                'letra_factura' => $letra_factura,            
    			'modelo' => $modelo,
    			'model' => $model,
    			'tributo' => Facturastributo::find()->where(['facturaid'=>$id])->all(),
    			'iva' => Facturasiva::find()->where(['facturaid'=>$id])->one(),
    			'item' => Facturasitem::find()->where(['facturaid'=>$id])->all(),
    			'pie' => $pie,
    			'formaspago' => Formaspagofe::find()->where(['pagoid'=>$pie->formapagoid])->one(),
    			'nota' => Facturasnotas::find()->where(['facturaid'=>$id])->all(),
    			'comprobante' => Tipocomprobantefe::find()->where(['comprobanteid'=>$model->comprobanteid])->one(),
    			'empresa' => $empresa,
    			'provincias' => Provinciasfe::find()->where(['provinciaid'=>$empresa->provinciaid])->one(),
    			'puntoventa' => Puntosventa::find()->where(['puntoventaid'=>$model->puntoventa])->one(),
    			'receptor' => $receptor,
    			'responsablecli' => Tiporesponsablefe::find()->where(['responsableid'=>$model->responsableid])->one(),
    	]);
    }
    
    
    
    /**
     * Creates a new Facturasenc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isGuestGoHome();
    	
//         $model = new Facturasenc();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->facturaid]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
    }

    /**
     * Updates an existing Facturasenc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//     public function actionUpdate($id)
//     {
//     	$this->isGuestGoHome();
    	
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->facturaid]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Deletes an existing Facturasenc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//     	$this->isGuestGoHome();
    	
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
    }



    /**
     * Finds the Facturasenc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Facturasenc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->isGuestGoHome();
        
        $model = null;
        
        if (EmpresasAdmin::isAdmin()) {
            $model = Facturasenc::find()->andWhere(['facturaid'=>$id])->one();
        }
        else {
            $model = Facturasenc::find()->where(['empresaid'=>Yii::$app->user->identity->empresaid])
                    ->andWhere(['facturaid'=>$id])->one();
        }
        
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
