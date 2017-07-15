<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

use backend\models\Mails;
use backend\models\UpdateForm;
use backend\models\PerfilPassword;
use backend\models\PerfilEmail;
use backend\models\PerfilConsolaDescripcion;

/**
 * Site controller
 */
class PerfilController extends Controller
{

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionPassword()
    {
    	$this->isGuestGoHome();
    	 
    	$model = new PerfilPassword();
    	
    	if ($model->load(Yii::$app->request->post())) {
    		if ($model->update()) {
    			Yii::$app->session->setFlash('success', 'Se realizaron los cambios correctamente.');
    			return $this->redirect(['password']);
    		} 
    		else {
    			Yii::$app->session->setFlash('danger', 'Disculpe, No se pudo realizar la modificacion intente más tarde.');
    		}
    	}
    
    	return $this->render('password', ['model' => $model]);
    }

    public function actionEmail()
    {
    	$this->isGuestGoHome();
    
    	$model = new PerfilEmail();
    	 
    	if ($model->load(Yii::$app->request->post())) {
    		if ($model->update()) {
    			Yii::$app->session->setFlash('success', 'Se realizaron los cambios correctamente.');
    			return $this->redirect(['email']);
    		}
    		else {
    			Yii::$app->session->setFlash('danger', 'Disculpe, No se pudo realizar la modificacion intente más tarde.');
    		}
    	}
    
    	return $this->render('email', ['model' => $model]);
    }
    
    public function actionConsolaDescripcion()
    {
    	$this->isGuestGoHome();
    
		$model = new PerfilConsolaDescripcion();
    	
    	if ($model->load(Yii::$app->request->post())) {
    		if ($model->update()) {
    			Yii::$app->session->setFlash('success', 'Se realizaron los cambios correctamente.');
    			return $this->redirect(['consola-descripcion']);
    		} 
    		else {
    			Yii::$app->session->setFlash('danger', 'Disculpe, No se pudo realizar la modificacion intente más tarde.');
    		}
    	}
    
    	return $this->render('consola-descripcion', ['model' => $model]);
    }
    	    
    
}
