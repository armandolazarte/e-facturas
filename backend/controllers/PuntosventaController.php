<?php

namespace backend\controllers;

use Yii;
use backend\models\Puntosventa;
use backend\models\Modelofactura;
use backend\models\PuntosventaEmpresas;
use backend\models\PuntosventaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Facturasenc;

/**
 * PuntosventaController implements the CRUD actions for Puntosventa model.
 */
class PuntosventaController extends Controller
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
     * Lists all Puntosventa models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isGuestGoHome();
    	
        $searchModel = new PuntosventaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Puntosventa model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	return $this->redirect(['index']);
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
    }

    /**
     * Creates a new Puntosventa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isGuestGoHome();
    	
        $model = new Puntosventa();

        if ($model->load(Yii::$app->request->post())) {
        	if (PuntosventaSearch::isPuntoVentaEmpresaExist($model->puntoventa)) {
		
        		Yii::$app->getSession()->setFlash('danger', 'El punto de venta <b>' . $model->puntoventa . '</b> ya se encuentra registrado en su lista de puntos de venta.');        		
        	}
        	else {
        		$model->empresaid = Yii::$app->user->identity->empresaid;
        		$model->fecha = date('Y-m-d H:i:s.');
        		
        		$pv = $model->save();
        		$mf = ModeloFactura::generateModeloFactura($model->puntoventaid);
        		$pve = PuntosventaEmpresas::createPuntoVentaEmpresa($model->puntoventaid);
        		
        		if ($pv === true && $mf !== null && $pve === true) {
	        		Yii::$app->getSession()->setFlash('success', 'El punto de venta <b>' . $model->puntoventa . '</b> se agregó correctamente.');
        		}
        		else {
        			Yii::$app->getSession()->setFlash('danger', 'Hubo un problema al intentar crear el punto de venta <b>' . $model->puntoventa . '</b>. Intentelo nuevamente.');
        			$model = $this->findModel($model->puntoventaid);
			    	$model->delete();
			    	$modelo_factura = Modelofactura::getModeloFacturaByPuntoVentaId($model->puntoventaid);
			    	$modelo_factura->delete();
			    	PuntosventaEmpresas::deletePuntoVentaEmpresa($model->puntoventaid);
        		}
        		
        		return $this->redirect(['index']);
        	}
//             return $this->redirect(['view', 'id' => $model->puntoventaid]);
        }
		
		return $this->render('create', [
                'model' => $model,
            ]);

    }

    /**
     * Updates an existing Puntosventa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isGuestGoHome();
    	
    	// se comprueba que sea un Puntoventaid de la empresa
    	if (PuntosventaSearch::getPuntoVentaEmpresaById($id))
    	{
    		
        	$model = $this->findModel($id);

	        if ($model->load(Yii::$app->request->post()) && $model->save()) {
// 	            return $this->redirect(['view', 'id' => $model->puntoventaid]);
	        	return $this->redirect(['index']);
	        } else {
	            return $this->render('update', [
	                'model' => $model,
	            ]);
	        }
    	}
    	return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Puntosventa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$this->isGuestGoHome();
    	
    	// se chequea si el punto de venta tiene facturas
    	$query = Facturasenc::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['puntoventa' => $id])
    	->asArray()
    	->one();
    	
    	$model = $this->findModel($id);
    	
    	
    	// si el punto de venta tiene facturas no se puede eliminar.
    	if ($query) {
    		Yii::$app->getSession()->setFlash('danger', 'No es posible eliminar el punto de venta <b>'.$model->puntoventa.'</b>. Existen facturas realizadas con este punto de venta.');
    	}
    	else {
	    	if ($model->delete()){
	    		if (($modelo_factura = Modelofactura::getModeloFacturaByPuntoVentaId($id)) !== null) {
	    			$modelo_factura->delete();
	    		}
	    		PuntosventaEmpresas::deletePuntoVentaEmpresa($id);
	    		
	    		Yii::$app->getSession()->setFlash('success', 'El punto de venta <b>'.$model->puntoventa.'</b> se ha eliminado correctamente.');
	    	}
    	}

        return $this->redirect(['index']);
    }

    /**
     * Finds the Puntosventa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Puntosventa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Puntosventa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
