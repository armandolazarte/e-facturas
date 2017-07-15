<?php

namespace backend\controllers;

use Yii;
use backend\models\Configfactindex;
use backend\models\ConfigfactindexSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfigfactindexController implements the CRUD actions for Configfactindex model.
 */
class ConfigfactindexController extends Controller
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
     * Lists all Configfactindex models.
     * @return mixed
     */
    public function actionIndex()
    {
//         $searchModel = new ConfigfactindexSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);

    	return $this->redirect(['update']);
    }

    /**
     * Displays a single Configfactindex model.
     * @param integer $id
     * @return mixed
     */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

    /**
     * Creates a new Configfactindex model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new Configfactindex();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->empresaid]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing Configfactindex model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Configfactindex::find()->where(['empresaid'=>Yii::$app->user->identity->empresaid])->one();

        if ($model !== null) {
        	
            $post = Yii::$app->request->post();
            if (isset($post)) {
                if(count($post)>0) {
                    $model->impresa_receptor = $post['Configfactindex']['impresa_receptor'];
               }
            }

	        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	            return $this->redirect(['facturasenc/index']);
	        } else {
	            return $this->render('update', [
	                'model' => $model,
	            ]);
	        }

        }
        
        else {
        	Configfactindex::createDefault();
            return $this->redirect(['index']);
        	$mensaje = 'La empresa no existe en Configfactindex. Comuniquese con su proveedor';
        	return $this->redirect(['error','mensaje'=>$mensaje]);
        }
    }

    /**
     * Deletes an existing Configfactindex model.
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
     * Finds the Configfactindex model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Configfactindex the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
//     protected function findModel($id)
//     {
    	
//         if (($model = Configfactindex::findfind()->where(['empresaid'=>Yii::$app->user->identity->empresaid])->one()) !== null) {
//             return $model;
//         } else {
//             throw new NotFoundHttpException('The requested page does not exist.');
//         }
//     }

    
    public function actionError($mensaje=null)
    {
    	// $this->isGuestGoHome();
    
    	return $this->render('error', ['mensaje' => $mensaje]);
    }
    
    
}
