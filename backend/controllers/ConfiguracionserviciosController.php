<?php

namespace backend\controllers;

use Yii;
use backend\models\Configuracionservicios;
use backend\models\ConfiguracionserviciosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfiguracionserviciosController implements the CRUD actions for Configuracionservicios model.
 */
class ConfiguracionserviciosController extends Controller
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
     * Lists all Configuracionservicios models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isGuestGoHome();
    	
        $searchModel = new ConfiguracionserviciosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $configServicio = ConfiguracionserviciosSearch::isConfigServiciosEmpresaExist();

        if ($configServicio) {
        	return $this->redirect(['view', 'id' => $configServicio->configid]);
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'configServicio' => $configServicio,
        ]);
    }

    /**
     * Displays a single Configuracionservicios model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$this->isGuestGoHome();
    	
    	// se comprueba que sea un Configid de la empresa
    	if (ConfiguracionserviciosSearch::getConfigServiciosEmpresaById($id))
    	{
	        return $this->render('view', [
	            'model' => $this->findModel($id),
	        ]);
    	}
    	
    	return $this->redirect(['index']);
    }

    /**
     * Creates a new Configuracionservicios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isGuestGoHome();
    	
    	$configServicio = ConfiguracionserviciosSearch::isConfigServiciosEmpresaExist();

    	// si la empresa ya tiene un servicio configurado no permie crear otro
    	if ($configServicio) {
    		return $this->redirect(['index']);
    	}
    	
        $model = new Configuracionservicios();

        if ($model->load(Yii::$app->request->post())) {
        	
        	$model->empresaid = Yii::$app->user->identity->empresaid;
        	$model->fecha = date('Y-m-d H:i:s.');
        	$model->produccion = 1;
        	$model->save();
            return $this->redirect(['view', 'id' => $model->configid]);
        } 
        else {
        	$configDefault = ConfiguracionserviciosSearch::getConfigServiciosEmpresaDefault();
        	
        	$model = $configDefault;
        	
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Configuracionservicios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isGuestGoHome();
    	
    	// se comprueba que sea un Configid de la empresa
    	if (ConfiguracionserviciosSearch::getConfigServiciosEmpresaById($id))
    	{
	        $model = $this->findModel($id);
    		
	        if ($model->load(Yii::$app->request->post())) { 
	        	if ($model->save()) {
	        	
	        	}
	            return $this->redirect(['view', 'id' => $model->configid]);
	        } 
    	
			return $this->render('update', [
	                'model' => $model,
	            ]);
    	}    	

    	return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Configuracionservicios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$this->isGuestGoHome();
    	
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Configuracionservicios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Configuracionservicios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Configuracionservicios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
