<?php

namespace backend\controllers;

use Yii;
use backend\models\Configempresasindex;
use backend\models\ConfigempresasindexSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Formato;

/**
 * ConfigempresasindexController implements the CRUD actions for Configempresasindex model.
 */
class ConfigempresasindexController extends Controller
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
     * Lists all Configempresasindex models.
     * @return mixed
     */
    public function actionIndex()
    {
//         $searchModel = new ConfigempresasindexSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
    	return $this->redirect(['empresas/index']);
    }

    /**
     * Displays a single Configempresasindex model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
    	return $this->redirect(['empresas/index']);
    }

    /**
     * Creates a new Configempresasindex model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//         $model = new Configempresasindex();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->empresaid]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
    	return $this->redirect(['empresas/index']);
    }

    /**
     * Updates an existing Configempresasindex model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
    	$this->isNotEmpresaAdminGoHome();
    	
        $model = $this->findModel(Yii::$app->user->identity->empresaid);

        if ($model->load(Yii::$app->request->post())) {
        	
        	$model->fchdde = Formato::fechaDataPickerToSql($model->fchdde);
        	$model->fchhta = Formato::fechaDataPickerToSql($model->fchhta);        	
        	
        	if ($model->save()) {
//         		return $this->redirect(['empresas/index']);

                $params = ['view' => 'empresas/index', 
                        'title' => 'cargando datos empresas . . .',
                        'spinner' => 'spinner',
                ];
                $var_session = Formato::generateRandomLetters();
                Yii::$app->session->set($var_session, $params);
                
        		return $this->redirect(['site/redirect', 'params' => $var_session]);
	        }
        } 
        else {
        	
        	$model->fchdde = Formato::fechaSqlToDataPicker($model->fchdde);
        	$model->fchhta = Formato::fechaSqlToDataPicker($model->fchhta);
        	
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Configempresasindex model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//         $this->findModel($id)->delete();

        return $this->redirect(['empresas/index']);
    }

    /**
     * Finds the Configempresasindex model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Configempresasindex the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Configempresasindex::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
