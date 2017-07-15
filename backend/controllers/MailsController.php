<?php

namespace backend\controllers;

use Yii;
use backend\models\Mails;
use backend\models\MailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MailsController implements the CRUD actions for Mails model.
 */
class MailsController extends Controller
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
     * Lists all Mails models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isGuestGoHome();
    	
        $searchModel = new MailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mails model.
     * @param integer $id
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
     * Creates a new Mails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isGuestGoHome();
    	
        $model = new Mails();

        if ($model->load(Yii::$app->request->post())) {
        	if (MailsSearch::isMailEmpresaExist($model->mail)) {
        		
        		Yii::$app->getSession()->setFlash('danger', 
        		'El email <b>' . $model->mail . '</b> ya se encuentra registrado en su lista de emails.');
        	}
        	else {
	        	$model->empresaid = Yii::$app->user->identity->empresaid;
	        	$model->save();
	        	Yii::$app->getSession()->setFlash('success',
	        	'El email <b>' . $model->mail . '</b> se agregó correctamente.');
	            return $this->redirect(['index']);
        	}
//             return $this->redirect(['view', 'id' => $model->mailid]);
        } 

		return $this->render('create', [
					'model' => $model,
			]);

    }

    /**
     * Updates an existing Mails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isGuestGoHome();
    	
    	// se comprueba que sea un mailid de la empresa
    	if (MailsSearch::getMailEmpresaById($id))
    	{
    		
	        $model = $this->findModel($id);
	
	        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	//             return $this->redirect(['view', 'id' => $model->mailid]);
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
     * Deletes an existing Mails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$this->isGuestGoHome();
    	
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
