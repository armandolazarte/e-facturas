<?php

namespace backend\controllers;

use Yii;
use backend\models\ComprobantesEnvio;
use backend\models\ComprobantesEnvioSearch;
use backend\models\Facturasenc;
use backend\models\ReceptorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComprobantesEnvioController implements the CRUD actions for ComprobantesEnvio model.
 */
class ComprobantesEnvioController extends Controller
{
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
     * Lists all ComprobantesEnvio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->isNotAdminGoHome();

        $searchModel = new ComprobantesEnvioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    /**
     * Lists all ComprobantesEnvio models.
     * @return mixed
     */
    public function actionErrores()
    {
        $this->isGuestGoHome();

    	$searchModel = new ComprobantesEnvioSearch();
    	$dataProvider = $searchModel->getErroresEmpresa(Yii::$app->request->queryParams);
            
        $query_errores = ComprobantesEnvioSearch::getQueryErroresEmpresa()->all();

    	return $this->render('errores', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
                'query_errores' => $query_errores,
    	]);
    }
    
    
    /**
     * Displays a single ComprobantesEnvio model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->isGuestGoHome();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGetEnvio($params)
    {
    	$this->isGuestGoHome();
    
    	$var_session = Yii::$app->session->get($params);
    	
    	if (count($var_session) == 0) {
    		$mensaje = 'Hubo un error. No existen datos a previsualizar.';
    		return $this->redirect(['error', 'mensaje' => $mensaje]);
    	}
    	
    	$model = Facturasenc::getFacturaEncabezado($var_session['facturaid']); 
    	$receptor = ReceptorSearch::getReceptorById($model['receptorid']);
    	$model['cuit'] = $receptor['cuit'];

    	$model['puntoventa_nro'] = $var_session['puntoventa'];
    	$model['comprobante'] = $var_session['comprobante'];
    	$model = array_merge($var_session, $model);

    	/*
    	 * $model = [Array Asociativo] ----> contiene los datos de la factura con error
    	 * 
    	 * Array ( 
    	 * [0] => facturaid [1] => puntoventa [2] => comprobante [3] => fecha_rechazo 
    	 * [4] => observaciones [5] => errores [6] => empresaid [7] => receptorid 
    	 * [8] => comprobanteid [9] => comprobantenro [10] => letra [11] => fechafactura 
    	 * [12] => clienteid [13] => nombre [14] => responsableid [15] => direccion 
    	 * [16] => localidad [17] => provinciaid [18] => telefono [19] => email 
    	 * [20] => url [21] => conceptoid [22] => notificada [23] => impresacliente 
    	 * [24] => impresaproveedor [25] => homologacion [26] => cuit [27] => puntoventa_nro [28] => comprobante
    	 * )
    	 * 
    	 * */
    	
    	$facturaid_con_cae = ComprobantesEnvioSearch::getFacturaIdAnteriorConCae($model);
    	$facturaEnc_con_cae = Facturasenc::getFacturaEncabezado($facturaid_con_cae['id']);
        $receptor = ReceptorSearch::getReceptorById($facturaEnc_con_cae['receptorid']);
        $facturaPie_con_cae = ComprobantesEnvioSearch::getFacturasPieByFacturaId($facturaid_con_cae['id']);

        if ($facturaEnc_con_cae === null) {
            $mensaje = 'NO HAY FACTURA ANTERIOR';
            $facturaEnc_con_cae['facturaid'] = 0;
            $facturaEnc_con_cae['comprobantenro'] = $mensaje;
            $facturaEnc_con_cae['fechafactura'] = $mensaje;
            $facturaEnc_con_cae['clienteid'] = $mensaje;
            $facturaEnc_con_cae['direccion'] = $mensaje;
            $facturaEnc_con_cae['cuit'] = $mensaje;
            $facturaEnc_con_cae['localidad'] = $mensaje;
            $facturaEnc_con_cae['nombre'] = $mensaje;

            $facturaPie_con_cae['cae'] = $mensaje;
            
        }
        else {
            $facturaEnc_con_cae['cuit'] = $receptor['cuit'];

        }

        $facturaEnc_con_cae['puntoventa_nro'] = $var_session['puntoventa'];
        $facturaEnc_con_cae['comprobante'] = $var_session['comprobante'];


        $model['empresaid'] = $var_session['empresaid'];
    	
    	return $this->render('get-envio', [
    			'model' => $model,
    			'facturaEnc_con_cae' => $facturaEnc_con_cae,
    			'facturaPie_con_cae' => $facturaPie_con_cae,
    	]);
    }
    
    
    public function actionError($mensaje=null)
    {
    	// $this->isGuestGoHome();
    
    	return $this->render('error', ['mensaje' => $mensaje]);
    }
    
    /**
     * Creates a new ComprobantesEnvio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new ComprobantesEnvio();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->comprobanteenvioid]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing ComprobantesEnvio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->comprobanteenvioid]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Deletes an existing ComprobantesEnvio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

    /**
     * Finds the ComprobantesEnvio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ComprobantesEnvio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComprobantesEnvio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
