<?php

namespace backend\controllers;

use Yii;
use backend\models\FacturasDebugger;
use backend\models\FacturasDebuggerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FacturasDebuggerController implements the CRUD actions for FacturasDebugger model.
 */
class FacturasDebuggerController extends Controller
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
     * Lists all FacturasDebugger models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isNotAdminGoHome();
    	
    	return $this->redirect(['create']);
    	
        $searchModel = new FacturasDebuggerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $factura_debug = FacturasDebugger::find()->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'factura_debug' => $factura_debug,
        ]);
    }

    /**
     * Displays a single FacturasDebugger model.
     * @param string $id
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
     * Creates a new FacturasDebugger model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isNotAdminGoHome();
    	
        $model = new FacturasDebugger();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	
        	Yii::$app->getSession()->setFlash('success', '<b>Actualizado</b>');
            return $this->redirect(['update', 'id' => $model->facturaid]);
        } else {
        	
        	$factura_debug = FacturasDebugger::find()->one();
        	if ($factura_debug !== null) {
        		return $this->redirect(['update', 'id' => $factura_debug->facturaid]);
        	}
        	
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FacturasDebugger model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isNotAdminGoHome();
    	
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	
        	Yii::$app->getSession()->setFlash('success', '<b><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Actualizado</b>');
            return $this->redirect(['update', 'id' => $model->facturaid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FacturasDebugger model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FacturasDebugger model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FacturasDebugger the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FacturasDebugger::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
