<?php

namespace backend\controllers;

use Yii;
use common\models\Formato;
use backend\models\Empresas;
use backend\models\EmpresasEmailSender;
use backend\models\EmpresasEmailSenderSearch;
use backend\models\VistasAudita;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmpresasEmailSenderController implements the CRUD actions for EmpresasEmailSender model.
 */
class EmpresasEmailSenderController extends Controller
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
     * Lists all EmpresasEmailSender models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$this->isGuestGoHome();
    	
    	VistasAudita::saveVistaAudita('Notificaciones');
    	
   		return $this->redirect(['create']);
    	
    }

    /**
     * Displays a single EmpresasEmailSender model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
    	$this->isGuestGoHome();
    	
    	$model = $this->findModel();
    	
    	if ($model === null) {
    		return $this->redirect(['create']);
    	}
    	
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    /**
     * Displays a single EmpresasEmailSender model.
     * @param string $id
     * @return mixed
     */
    public function actionPublicView($id)
    {
    	if (!is_numeric($id)) {
    		return $this->goHome();
    	}
    	
    	$model = EmpresasEmailSender::find()
    	->where(['empresaid'=>$id])
    	->one();
    	
    	if ($model === null) {
	    	return $this->goHome();
    	}
    	 
    	return $this->render('view', [
    			'model' => $model,
    	]);
    }
    
    /**
     * Creates a new EmpresasEmailSender model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->isGuestGoHome();
    	
    	if ($this->findModel() !== null) {
    		return $this->redirect(['view']);
    	}
    	
    	$id_emp = Yii::$app->user->identity->empresaid;
    	$nom_emp = Empresas::find()->where(['empresaid'=>$id_emp])->one()->razonsocial;
    	
        $model = new EmpresasEmailSender();
        $model->empresaid = $id_emp;
        $model->nombre = $nom_emp;
        $model->servidor_smpt = 'smtp.gmail.com';
        $model->puerto_smpt = '587';
        //$model->email = '@gmail.com';
        
//         echo $model->hash_validate;
//         exit;

        if ($model->load(Yii::$app->request->post())) {

            $model->servidor_smpt = 'smtp.gmail.com';
            $model->puerto_smpt = '587';

        	if ($model->updateNotificar() === null) {
        		Yii::$app->getSession()->setFlash('danger',
        		'Disculpe, no se pudieron guardar los cambios. Vuelva a intentarlo.');
        		
        	}
        	else if ($model->updateNotificar() === false) {
        		Yii::$app->getSession()->setFlash('danger',
        		'Su <b>Password Actual</b> no es correcta. Vuelva a intentarlo.');

        	}        	
            else {
            	Yii::$app->session->set('email_error_acount','OK');
                $model->sendEmailValidation();
        		
        		if (Yii::$app->session->get('email_error_acount') === 'ERROR') {
        			Yii::$app->getSession()->setFlash('danger', 'Su <b>Password Email</b> no es correcta. Vuelva a intentarlo.');        			
	        		return $this->redirect(['update']);
        		}
        		else {
		        	Yii::$app->getSession()->setFlash('success', 'Revise su casilla de email <b>'.$model->email.'</b>. Se le ha enviado un link para activar su cuenta.');
		        	return $this->redirect(['view']);
        		}
            	
        	}

        }
		return $this->render('create', [
                'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmpresasEmailSender model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
    	$this->isGuestGoHome();
    	
        $model = $this->findModel();
    	
    	if ($model === null) {
    		return $this->redirect(['create']);
    	}

        if ($model->load(Yii::$app->request->post())) {

            //$model->servidor_smpt = 'smtp.gmail.com';
            //$model->puerto_smpt = '587';            

			if ($model->updateNotificar() === null) {
        		Yii::$app->getSession()->setFlash('danger',
        		'Disculpe, no se pudieron guardar los cambios. Vuelva a intentarlo.');
        		
        	}
        	else if ($model->updateNotificar() === false) {
        		Yii::$app->getSession()->setFlash('danger',
        		'Su <b>Password Actual</b> no es correcta. Vuelva a intentarlo.');

        	}        	
        	else {
        		Yii::$app->session->set('email_error_acount','OK');
        		$model->sendEmailValidation();
        		
        		if (Yii::$app->session->get('email_error_acount') === 'ERROR') {
        			Yii::$app->getSession()->setFlash('danger', 'No se pudo enviar el correo. Revise su Password Email y vuelva a intentarlo.');        			
        		}
        		else {
		        	Yii::$app->getSession()->setFlash('success', 'Revise su casilla de email <b>'.$model->email.'</b>. Se le ha enviado un link para activar su cuenta.');
		        	return $this->redirect(['view']);
        		}
        	}
		}
		
        return $this->render('update', [
                'model' => $model,
        ]);
    }
    
    
    
    public function actionValidateEmailAcount($id=NULL, $token=NULL)
    {
    	
    	if (!is_numeric($id) || !EmpresasEmailSender::isHash($token)) {
    		return $this->goHome();
    	}
    	
    	$model = EmpresasEmailSender::find()
	    			->where(['empresaid'=>$id])
	    			->andWhere(['hash_validate'=>$token])
	    			->one();
    	
    	
    	if ($model == null) {
    		return $this->goHome();
    	}
    	
    	if (EmpresasEmailSender::activateEmailAcount($id, $token)) {
    		Yii::$app->getSession()->setFlash('info', 'Su cuenta de email se ha activado con éxito. Ya puede notificar a sus clientes utilizando su correo electrónico.');

    		if (Yii::$app->user->isGuest) {
	    		return $this->redirect(['public-view', 'id' => $id]);
    		}
    		else {
    			return $this->redirect(['view']);
    		}
    	}
    	else {
			Yii::$app->getSession()->setFlash('danger', 'Disculpe, no se pudieron guardar los cambios. Vuelva a intentarlo.');
    		return $this->redirect(['view']);
    	}
    	
    	return $this->goHome();
    	
    }    

    /**
     * Deletes an existing EmpresasEmailSender model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
    	$model = $this->findModel();
    	 
    	if ($model === null) {
    		return $this->redirect(['create']);
    	}
    	
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmpresasEmailSender model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EmpresasEmailSender the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
    	 
    	$model = EmpresasEmailSender::find()
		    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
		    	->one();
    	 
    	if ($model !== null) {
    		
    		$model->nombre = Formato::htmlEntitiesToTildes($model->nombre);
    		return $model;
        } 
        else {
            return null;
        }
    }
}
