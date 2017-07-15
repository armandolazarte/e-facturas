<?php

namespace backend\controllers;

use Yii;
use backend\models\ConfigPeriodoErroresFe;
use backend\models\ConfigPeriodoErroresFeSearch;
use backend\models\EmpresasAdmin;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfigPeriodoErroresFeController implements the CRUD actions for ConfigPeriodoErroresFe model.
 */
class ConfigPeriodoErroresFeController extends Controller
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
     * Lists all ConfigPeriodoErroresFe models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isNotAdminGoHome();
    	
        $searchModel = new ConfigPeriodoErroresFeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ConfigPeriodoErroresFe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->isGuestGoHome();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ConfigPeriodoErroresFe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->isGuestGoHome();

        $model = new ConfigPeriodoErroresFe();
        
        $model->empresaid = (EmpresasAdmin::isAdmin(Yii::$app->user->identity->empresaid)) ? 0 : Yii::$app->user->identity->empresaid;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->empresaid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ConfigPeriodoErroresFe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->isGuestGoHome();

        $id = (EmpresasAdmin::isAdmin(Yii::$app->user->identity->empresaid)) ? 0 : Yii::$app->user->identity->empresaid;
        
        $model = ConfigPeriodoErroresFe::findOne($id);

        //var_dump($model);


        
        if ($model === null) {
            $model = new ConfigPeriodoErroresFe();
            $model->empresaid = (integer)$id;
            $model->periodo = '2';
            $model->save();
            $model = $this->findModel($id);
            //return $this->redirect(['update', 'id' => $model->empresaid]);
        }

        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	if (EmpresasAdmin::isAdmin(Yii::$app->user->identity->empresaid)) {
	             return $this->redirect(['comprobantes-envio/index']);
        	}
        	else {
        		return $this->redirect(['comprobantes-envio/errores']);
        	} 
        		
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ConfigPeriodoErroresFe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

    /**
     * Finds the ConfigPeriodoErroresFe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfigPeriodoErroresFe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfigPeriodoErroresFe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
