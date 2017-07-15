<?php

namespace backend\controllers;

use Yii;
use backend\models\Empresas;
use backend\models\EmpresasSearch;
use backend\models\Configempresasindex;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmpresasController implements the CRUD actions for Empresas model.
 */
class EmpresasController extends Controller
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
     * Lists all Empresas models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isNotEmpresaAdminGoHome();
    	
        $searchModel = new EmpresasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         $fechas = EmpresasSearch::getFechasConfigEmpresasIndex();
        
        $fechas = Configempresasindex::findOne(Yii::$app->user->identity->empresaid);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'fechas' => $fechas,
        ]);
    }
    
    public function actionComprobantes($id=null)
    {
    	$this->isNotEmpresaAdminGoHome();
//     	Yii::$app->user->identity->empresaid
    	 
    	$model = EmpresasSearch::getComprobantesByEmpresaId($id);
    	
    	if ($model === null) {
    		return $this->redirect(['index']);
    	}
    	
    	$fechas = Configempresasindex::findOne(Yii::$app->user->identity->empresaid);
    	
    	return $this->render('comprobantes', [
    			'model' => $model,
    			'empresa' => Empresas::find()->where(['empresaid'=>$id])->one()->razonsocial,
    			'fechas' => $fechas,
    	]);
    }    

    /**
     * Displays a single Empresas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$this->isNotEmpresaAdminGoHome();
    	
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Empresas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//         $model = new Empresas();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->empresaid]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }

    	return $this->redirect(['index']);
    }

    /**
     * Updates an existing Empresas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->empresaid]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
		
    	return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Empresas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//         $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    public function actionSelected(){
    	
    	
    	if (Yii::$app->request->isAjax) {
    		
//     		$pk = Yii::$app->request->post();
	    	$pk = Yii::$app->request->post('pk');
    		print_r($pk);
    		echo '+++++++++++++++++++++';
    	}
    	echo '-----------------------';
    	
    	foreach ($pk as $id) {
    		$this->findModel($id)->delete();
    	}
    	
//     	return $this->redirect(['index']);
    }

    /**
     * Finds the Empresas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Empresas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
