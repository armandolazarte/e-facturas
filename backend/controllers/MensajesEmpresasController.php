<?php

namespace backend\controllers;

use Yii;
use common\models\Formato;
use backend\models\MensajesEmpresas;
use backend\models\Empresas;
use backend\models\MensajesEmpresasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MensajesEmpresasController implements the CRUD actions for MensajesEmpresas model.
 */
class MensajesEmpresasController extends Controller
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
     * Lists all MensajesEmpresas models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isNotAdminGoHome();
    	
        $searchModel = new MensajesEmpresasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MensajesEmpresas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$this->isNotAdminGoHome();
    	
		$empresas = Empresas::getEmpresasArray('razonsocial', 'razonsocial');
    	
		$model = $this->findModel($id);
		
        return $this->render('view', [
			'empresas' => $empresas,
            'model' => $model
        ]);
    }

    /**
     * Creates a new MensajesEmpresas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isNotAdminGoHome();
    	
    	$model = new MensajesEmpresas();
    	
    	$empresas = Empresas::getEmpresas();
    	$empresas_razon_razon = Empresas::getEmpresasArray('razonsocial', 'razonsocial');
		$empresas_razon_id = Empresas::getEmpresasArray('razonsocial', 'empresaid');
    	 

        if ($model->load(Yii::$app->request->post())) {
        	
//         	$model->empresaid = $empresas_razon_id[$model->empresa];
        	$model->empresa = '-';
        	$model->titulo = Formato::tildesToHtmlEntities($model->titulo);
        	$model->descripcion = Formato::tildesToHtmlEntities($model->descripcion);        	
        	$model->vigenciadesde = Formato::fechaDataPickerToSql($model->vigenciadesde);
        	$model->vigenciahasta = Formato::fechaDataPickerToSql($model->vigenciahasta);
        	
        	$model->activo = ($model->activo == 1) ? 'SI' : 'NO';
        	$model->permitecerrar = ($model->permitecerrar == 1) ? 'SI' : 'NO';

        	$pk_facturas = Yii::$app->session->get('QueryEmpresasSelect');
        	
        	if (count($pk_facturas) > 0) {
        		$model->empresaid = implode(",",$pk_facturas);
        	}
        	else {
        		$model->empresaid = "NINGUNA";
        	}
        	
        	if ($model->save()) {
        
	            return $this->redirect(['view', 'id' => $model->mensajeid]);
        	}
        } 
        else {
        	$model->setValuesDefault();
            return $this->render('create', [
            	'empresas' => $empresas,
				'empresas_razon_razon' => $empresas_razon_razon,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MensajesEmpresas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isNotAdminGoHome();
    	
        $model = new MensajesEmpresas();
        $model = $this->findModel($id);
        
        $empresas = Empresas::getEmpresas();
        $empresas_razon_razon = Empresas::getEmpresasArray('razonsocial', 'razonsocial');
        $empresas_razon_id = Empresas::getEmpresasArray('razonsocial', 'empresaid');

        if ($model->load(Yii::$app->request->post())) {

        	$model->titulo = Formato::tildesToHtmlEntities($model->titulo);
        	$model->descripcion = Formato::tildesToHtmlEntities($model->descripcion);
        	$model->vigenciadesde = Formato::fechaDataPickerToSql($model->vigenciadesde);
        	$model->vigenciahasta = Formato::fechaDataPickerToSql($model->vigenciahasta);
         	$model->empresaid = str_replace(',', ', ', $model->empresaid);
        	$model->activo = ($model->activo == 1) ? 'SI' : 'NO';
        	$model->permitecerrar = ($model->permitecerrar == 1) ? 'SI' : 'NO';
        	
        	$pk_facturas = Yii::$app->session->get('QueryEmpresasSelect');

/*        	 
        	if (count($pk_facturas) > 0) {
        		$model->empresaid = implode(", ",$pk_facturas);
        	}
        	else {
        		$model->empresaid = "NINGUNA";
        	}
*/        	
        	if($model->save()) {
        		
    	        return $this->redirect(['view', 'id' => $model->mensajeid]);
	        }
        } 
        
        else {
        	
        	$model->activo = ($model->activo == 'SI') ? 1 : 0;
        	$model->permitecerrar = ($model->permitecerrar == 'SI') ? 1 : 0;
        	
            return $this->render('update', [
				'empresas' => $empresas,
				'empresas_razon_razon' => $empresas_razon_razon,
                'model' => $model,
            ]);
        }
    }
    
    
    public function actionSeleccionarEmpresas()
    {
    	$pk_empresas = [];
    	if (Yii::$app->request->isAjax) {
    		$pk = Yii::$app->request->post('pk');
    		if ($pk !== null) {
    			$pk_empresas = $pk;
// 				print_r($pk_empresas);
    		}
    	}
    	Yii::$app->session->set('QueryEmpresasSelect', $pk_empresas);
    }    

    /**
     * Deletes an existing MensajesEmpresas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MensajesEmpresas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MensajesEmpresas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MensajesEmpresas::findOne($id)) !== null) {

        	$model->titulo = Formato::htmlEntitiesToTildes($model->titulo);
        	$model->descripcion = Formato::htmlEntitiesToTildes($model->descripcion);        	
        	$model->vigenciadesde = Formato::fechaSqlToDataPicker($model->vigenciadesde);
        	$model->vigenciahasta = Formato::fechaSqlToDataPicker($model->vigenciahasta);
        	
        	return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
