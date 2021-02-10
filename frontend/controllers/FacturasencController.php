<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Formato;
use frontend\models\Facturasenc;
use frontend\models\FacturasForm;
use frontend\models\Facturastributo;
use frontend\models\Facturasiva;
use frontend\models\Facturasitem;
use frontend\models\Facturaspie;
use frontend\models\Empresas;
use frontend\models\Puntosventa;
use frontend\models\Tiporesponsablefe;
use frontend\models\Receptores;
use frontend\models\Facturasnotas;
use backend\models\FacturasVistaPublica;
use backend\models\EmpresaUser;
use backend\models\PuntosventaEmpresas;
// use backend\models\FacturasForm;
use backend\models\ModeloFactura;
use backend\models\ModeloFacturas;
use backend\models\Tipocomprobantefe;
use backend\models\Formaspagofe;
use backend\models\Provinciasfe;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

//     public function behaviors()
//     {
//         return [
//             'verbs' => [
//                 'class' => VerbFilter::className(),
//                 'actions' => [
//                     'delete' => ['post'],
//                 ],
//             ],
//         ];
//     }

    /**
     * Lists all Facturasenc models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isGuestGoHome();
    	
        $receptor = Receptores::find()->where(['cuit' => User::findIdentity(yii::$app->user->id)->cuit])->all();

        $receptor1 = $receptor[0]['receptorid'];
        $receptor2 = isset($receptor[1]['receptorid']) ? $receptor[1]['receptorid'] : $receptor1;

        
        $ORDEN = [
                    'comprobantenro' => SORT_DESC,
                    'letra' => SORT_DESC,
                ];

        $search = new FacturasForm();

        #Chequea si se ingresaron datos para filtrar
        if ($search->load(Yii::$app->request->post())) {
            $query = Facturasenc::find()
                            ->joinWith('facturaspies')
                            ->joinWith('empresa')
                            ->joinWith('puntoventa0')
                            ->where('(receptorid = :receptorid1 or receptorid = :receptorid2) and ifnull(cae,-1) > :cae',['receptorid1'=>$receptor1,'receptorid2'=>$receptor2,'cae' => 0])
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
            if ($search->empresa) {
                $query->andWhere('razonsocial like :razonsocial',['razonsocial'=>'%'.$search->empresa.'%']);
            }
            if ($search->nrodde) {
                $query->andWhere('comprobantenro >= :nrodde',['nrodde'=>$search->nrodde]);
            }
            if ($search->nrohta) {
                $query->andWhere('comprobantenro <= :nrohta',['nrohta'=>$search->nrohta]);
            }
            if ($search->impresa != -1) {
                $query->andWhere(['impresacliente'=>$search->impresa]);
            }
            $query->andWhere('receptorid = :receptorid1 or receptorid = :receptorid2',['receptorid1'=>$receptor1,'receptorid2'=>$receptor2]);


            #$this->facturasenc->setQueryFactura($query);
            Yii::$app->session->set('QueryFactura',$query);

            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
            		'pagination' => [
            				'pagesize' => -1,
            		],            		
                    //'sort' => ['defaultOrder' => ['facturaid' => SORT_DESC]],
                ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,#'model'=>$model,
                'search' => $search,
            ]);
        }
        else {
        #Si no se ingreso ningun filtro entonces trae las facturas no impresas

            $ORDEN = [
                        'comprobantenro' => SORT_DESC,
                        'letra' => SORT_DESC,
                    ];
            
            if ($receptor) {

                //print_r($receptor->receptorid);
                //exit();
                $query = Facturasenc::find()
                            ->joinWith('facturaspies')
                            ->where('(receptorid = :receptorid1 or receptorid = :receptorid2) and ifnull(cae,-1) > :cae',['receptorid1'=>$receptor1,'receptorid2'=>$receptor2,'cae' => 0])
                            //->andWhere(['impresacliente'=>0])
                            ->groupBy(['empresaid', 'receptorid', 'puntoventa', 'comprobanteid', 'comprobantenro', 'letra'])
                            ->orderBy($ORDEN);

                Yii::$app->session->set('QueryFactura',$query);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    //'sort' => ['defaultOrder' => ['facturaid' => SORT_DESC]],
                ]);

                return $this->render('index', [
                    'dataProvider' => $dataProvider,#'model'=>$model,
                    'search' => $search,
                ]);    
            }   
            else {
                return $this->render('index', [
                    'msg' => 'No tiene facturas para el DNI/CUIT configurado!',
                    'dataProvider' => '',
                    'search' => $search,
                ]);   
            }     
        }        
    }

    /**
     * Displays a single Facturasenc model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id, $key=null)
    {        
    	
		// si la key es NULL verifica que el usuario este logueado, sino lo saca de la vista
    	if ($key == null)
    		$this->isGuestGoHome();
	   
    	// si la key no tiene el formato de un hash sha256 verifica que el usuario este logueado, sino lo saca de la vista
    	if (!FacturasVistaPublica::isHash($key))
    		$this->isGuestGoHome();
    	
    	// si la key es un hash sha256 ...
    	if ($key) {
    		$view = FacturasVistaPublica::find()->where(['key'=>$key])->one();
    		// si la key existe en la tabla FacturasVistaPublica
    		// comprueba que la id de la tabla sea igual a la $id recibida por GET
    		if ($view) {
    			if ($id !== $view->facturaid) {
    				return $this->render('errorview');
    			}
    		}
    		else {
    			return $this->render('errorview');
    		}
    	}

    	$this->layout = "factura";
    	
    	$user = EmpresaUser::findIdentity(yii::$app->user->id);
        $model = $this->findModel($id);
    	//$empresa = Empresas::find()->where(['empresaid'=>$model->empresaid])->one();
    	

        
        
        $empresa = PuntosventaEmpresas::getPuntoVentaEmpresaById($model->puntoventa, $model->empresaid);
        
        $modelo = ModeloFacturas::find()->where(['empresaid'=>$empresa->empresaid])
                                        ->andWhere(['puntoventaid'=>$model->puntoventa])->one();
        



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

        //        $model->letra = 'AASDFASFA';
        $letra_factura = ModeloFactura::getLetraFactura($model->letra);
    	
    	$model->impresacliente = 1;
    	$model->save();

        foreach ($model as $clave => $valor) {
            $model->$clave = utf8_decode($model->$clave);
        }

	$pie->formapagoid = ($pie->formapagoid == null) ? 2 : $pie->formapagoid;
    	
        return $this->render('view', [
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


    public function actionImprimir()
    {
    	$this->isGuestGoHome();
    	 
    	$this->layout = "factura";
    	 
		$QUERY = Yii::$app->session->get('QueryFactura')->all();

		if (!$QUERY) {
			$mensaje = 'No existen facturas para los filtros aplicados previamente, vuelva a intentarlo.';
			return $this->redirect(['error', 'mensaje' => $mensaje]);
		}		
		
    	$EMPRESAID = $QUERY[0]['empresaid'];
    	$modelo = ModeloFacturas::find()->where(['empresaid'=>$EMPRESAID])->one();
    	
    	// se comprueba que la empresa tenga un modelo de factura configurado
    	// sino muestra un mensaje de error.
    	if ($modelo == null) {
    		$mensaje = 'Su empresa proveedora no se encuentra registrada en este sitio web.';
    		return $this->redirect(['error', 'mensaje' => $mensaje]);
    	}
    	
    	//$empresa = Empresas::find()->where(['empresaid'=>$EMPRESAID])->one();
        $empresa = PuntosventaEmpresas::getPuntoVentaEmpresaById($model->puntoventa, $model->empresaid);
    	 
    	$facturasimprimir = [];
    	foreach ($QUERY as $key) {
    		$model = Facturasenc::find()->where(['facturaid'=>$key->facturaid])->one();
    		$tributo = Facturastributo::find()->where(['facturaid'=>$key->facturaid])->all();
    		$iva = Facturasiva::find()->where(['facturaid'=>$key->facturaid])->one();
    		$item = Facturasitem::find()->where(['facturaid'=>$key->facturaid])->all();
    		$puntoventa = Puntosventa::find()->where(['puntoventaid'=>Facturasenc::find()->where(['facturaid'=>$key->facturaid])->one()->puntoventa])->one();
    		$responsable = Tiporesponsablefe::find()->where(['responsableid'=>Facturasenc::find()->where(['facturaid'=>$key->facturaid])->one()->responsableid])->one();
    		$receptor = Receptores::find()->where(['receptorid'=>Facturasenc::find()->where(['facturaid'=>$key->facturaid])->one()->receptorid])->one();
    		$responsablecli = Tiporesponsablefe::find()->where(['responsableid'=>Receptores::find()->where(['receptorid'=>Facturasenc::find()->where(['facturaid'=>$key->facturaid])->one()->receptorid])->one()->responsableid])->one();
    		$provincia = Provinciasfe::find()->where(['provinciaid'=>$empresa->provinciaid])->one()->descripcion;
    		$factura = Facturasenc::findOne($key->facturaid);
    		$comprobante = Tipocomprobantefe::find()->where(['comprobanteid'=>$factura->comprobanteid])->one();
    		$puntoventa = Puntosventa::find()->where(['puntoventaid'=>$factura->puntoventa])->one();
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
    
    		$factura->impresacliente = 1;
    		$factura->save();
    		
            foreach ($model as $clave => $valor) {
                $model->$clave = utf8_decode($model->$clave);
            }
            
    		$facturasimprimir[] = [
    				'id' => $key->facturaid,
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
    				'responsablecli' => $responsablecli->responsable,
    				'importegravado' => $pie->importegravado,
    				'importenogravado' => $pie->importenogravado,
    				'importeiva' => $pie->importeiva,
    				'importetributos' => $pie->importetributos,
    				'importetotal' => $pie->importetotal,
    				'cae' => $pie->cae,
    				'caevencimiento' => $pie->caevencimiento,
    				'detalle' => $detalle,
    				'provincia' => $provincia,
    				'telefono' => $empresa->telefono,
                    'email' => $empresa->email,
                    'url' => $empresa->url,
    				'comprobantecodigo' => $comprobante->codigo,
    				'formapago' => $formaspago->descripcion,
                    'nota' => $nota,
                    'tiporesponsable' => $receptor->documentoid,
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
//     	$this->isGuestGoHome();
    	 
    	return $this->render('error', ['mensaje' => $mensaje]);
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
    public function actionUpdate($id)
    {
    	$this->isGuestGoHome();
    	
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->facturaid]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
    }

    /**
     * Deletes an existing Facturasenc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$this->isGuestGoHome();
    	
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
//     	$this->isGuestGoHome();
    	
        if (($model = Facturasenc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
