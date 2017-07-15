<?php

namespace backend\controllers;

use Yii;
use backend\models\FacturasMensajesNotificacion;
use backend\models\FacturasMensajesNotificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FacturasMensajesNotificacionController implements the CRUD actions for FacturasMensajesNotificacion model.
 */
class FacturasMensajesNotificacionController extends Controller
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
     * Lists all FacturasMensajesNotificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FacturasMensajesNotificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FacturasMensajesNotificacion model.
     * @param string $id
     * @return mixed
     */
    public function actionView($pv, $c, $n, $id)
    {
    	$mensaje = FacturasMensajesNotificacion::getMensajeByFacturaid($id);
    	
    	if ($mensaje === null) {
	    	return $this->redirect(['facturasenc/index']);
    	}
    	else {
    		
	        return $this->render('view', [
	        		'puntoventa' => $pv,
	        		'comprobante' => $c,
	        		'numero' => $n,
	        		'mensaje' => $mensaje,
	        ]);
    	}
    }

    /**
     * Creates a new FacturasMensajesNotificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FacturasMensajesNotificacion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->facturaid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FacturasMensajesNotificacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->facturaid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FacturasMensajesNotificacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//         $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FacturasMensajesNotificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FacturasMensajesNotificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FacturasMensajesNotificacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
