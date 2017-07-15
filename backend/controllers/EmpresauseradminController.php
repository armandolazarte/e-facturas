<?php

namespace backend\controllers;

use Yii;
use backend\models\Empresauseradmin;
use backend\models\EmpresauseradminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmpresauseradminController implements the CRUD actions for Empresauseradmin model.
 */
class EmpresauseradminController extends Controller
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
     * Lists all Empresauseradmin models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isNotAdminGoHome();
    	
        $searchModel = new EmpresauseradminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Empresauseradmin model.
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
     * Creates a new Empresauseradmin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//         $model = new Empresauseradmin();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }

    	return $this->redirect(['index']);
    }

    /**
     * Updates an existing Empresauseradmin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }

    	return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Empresauseradmin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//         $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Empresauseradmin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresauseradmin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresauseradmin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
