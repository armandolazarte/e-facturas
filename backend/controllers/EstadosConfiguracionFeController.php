<?php

namespace backend\controllers;

use Yii;
use common\models\Formato;
use backend\models\EstadosConfiguracionFe;
use backend\models\EstadosConfiguracionFeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstadosConfiguracionFeController implements the CRUD actions for EstadosConfiguracionFe model.
 */
class EstadosConfiguracionFeController extends Controller
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
     * Lists all EstadosConfiguracionFe models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isNotAdminGoHome();
    	
        $searchModel = new EstadosConfiguracionFeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EstadosConfiguracionFe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$this->isNotAdminGoHome();
    	
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EstadosConfiguracionFe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isNotAdminGoHome();
    	
        $model = new EstadosConfiguracionFe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EstadosConfiguracionFe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isNotAdminGoHome();
    	
        $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {

        	
        	$model->titulo = Formato::tildesToHtmlEntities($model->titulo);
        	$model->descripcion = Formato::tildesToHtmlEntities($model->descripcion);
//         	$model->activo = ($model->activo == 1) ? 'SI' : 'NO';
        	
        	if($model->save()) {
        		
    	        return $this->redirect(['view', 'id' => $model->id]);
	        }
        
        } 

        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EstadosConfiguracionFe model.
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
     * Finds the EstadosConfiguracionFe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EstadosConfiguracionFe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstadosConfiguracionFe::findOne($id)) !== null) {

        	$model->titulo = Formato::htmlEntitiesToTildes($model->titulo);
        	$model->descripcion = Formato::htmlEntitiesToTildes($model->descripcion);
        	        	
        	return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
