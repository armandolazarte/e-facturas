<?php

namespace backend\controllers;

use Yii;
use backend\models\VistasAudita;
use backend\models\Vistas;
use backend\models\Empresas;
use backend\models\VistasAuditaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VistasAuditaController implements the CRUD actions for VistasAudita model.
 */
class VistasAuditaController extends Controller
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
     * Lists all VistasAudita models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isNotAdminGoHome();
    	
        $searchModel = new VistasAuditaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VistasAudita model.
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
     * Creates a new VistasAudita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isNotAdminGoHome();
    	return $this->redirect(['index']);
    	
//         $model = new VistasAudita();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
    }

    /**
     * Updates an existing VistasAudita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isNotAdminGoHome();
    	
        $model = $this->findModel($id);

        $vista = Vistas::getArrayVistaById($model->vistaid);
        
        $empresa = Empresas::getEmpresaByEmpresaId($model->empresaid);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
				'vista' => $vista,
            	'empresa' => $empresa,
            ]);
        }
    }

    /**
     * Deletes an existing VistasAudita model.
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
     * Finds the VistasAudita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VistasAudita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VistasAudita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
