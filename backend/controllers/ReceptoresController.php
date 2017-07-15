<?php

namespace backend\controllers;

use Yii;
use backend\models\Receptoresemails;
use backend\models\Receptores;
use backend\models\ReceptoresSearch;
use backend\models\Empresasreceptores;
use backend\models\VistasAudita;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\validators\CompareValidator;


/**
 * ReceptoresController implements the CRUD actions for Receptores model.
 */
class ReceptoresController extends Controller
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
     * Lists all Receptores models.
     * @return mixed
     */
    public function actionIndex()
    {

    	$this->isGuestGoHome();
    	
    	VistasAudita::saveVistaAudita('Receptores');
    	
    	$searchModel = new ReceptoresSearch();
    	
    	if (Yii::$app->session->get('filtro_receptores') === null) {
    		Yii::$app->session->set('filtro_receptores', $searchModel->filtro_principal);
    	}
    	
    	if (isset(Yii::$app->request->post()['ReceptoresSearch']['filtro_principal'])) {
    		$searchModel->filtro_principal = Yii::$app->request->post()['ReceptoresSearch']['filtro_principal'];
    		
	    	Yii::$app->session->set('filtro_receptores', $searchModel->filtro_principal);
    		
    	}
//     	echo '<br><br><br><br>';
//     	print_r(Yii::$app->session->get('filtro_receptores'));    	

    	if (Yii::$app->session->get('filtro_receptores') === 'CON EMAIL') {
    		 
    		$query = Receptores::find()
    		->joinWith('empresasreceptores')
    		->joinWith('receptoresemails')
    		->where(['not',['receptoresemails.email' => null]])
    		->orWhere(['not',['receptores.mail' => '']])
    		->andWhere(['empresasreceptores.empresaid'=>Yii::$app->user->identity->empresaid])
            ->andWhere(['receptores.empresaid'=>Yii::$app->user->identity->empresaid])
    		;
    	
    	}
    	else if (Yii::$app->session->get('filtro_receptores') === 'SIN EMAIL') {
    		$query = Receptores::find()
    		->joinWith('empresasreceptores')
    		->joinWith('receptoresemails')
    		->where(['empresasreceptores.empresaid'=>Yii::$app->user->identity->empresaid])
    		->andWhere(['receptores.empresaid'=>Yii::$app->user->identity->empresaid])
            ->andWhere(['receptoresemails.email' => null])
    		->andWhere(['receptores.mail' => ''])
    		;
    	}
    	else { //TODOS
    		$query = Receptores::find()->joinWith('empresasreceptores')
    		->where(['empresasreceptores.empresaid'=>Yii::$app->user->identity->empresaid])
            ->andWhere(['receptores.empresaid'=>Yii::$app->user->identity->empresaid]);
    	}
    	
        if ($searchModel->load(Yii::$app->request->post())) {
            if ($searchModel->cuit) {
                $query->andWhere(['like', 'cuit', $searchModel->cuit]);
            }
            if ($searchModel->nombre) {
                $query->andWhere(['like', 'nombre', $searchModel->nombre]);
            }
            if ($searchModel->direccion) {
                $query->andWhere(['like', 'direccion', $searchModel->direccion]);
            }
            if ($searchModel->localidad) {
                $query->andWhere(['like', 'localidad', $searchModel->localidad]);
            }
            if ($searchModel->telefono) {
                $query->andWhere(['like', 'telefono', $searchModel->telefono]);
            }
            if ($searchModel->mail) {
            	$query->andWhere(['like', 'mail', $searchModel->mail]);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        		'pagination' => array('pageSize' => 100),
        ]);

        $searchModel->filtro_principal = Yii::$app->session->get('filtro_receptores');
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Receptores model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$this->isGuestGoHome();
    	
    	$model = $this->findModel($id);
    	$model->emails = Receptoresemails::getArrayMailsByReceptorId($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Receptores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$this->isGuestGoHome();
    	
        $model = $this->findModel($id);
        
        $model->emails = Receptoresemails::getArrayMailsByReceptorId($id);
        
        // se hace una copia de los mails antes de la modificacion
        $model->emailsCopy = $model->emails;
        
        if ($model->load(Yii::$app->request->post())) {
        	
        	// se eliminan los emails duplicados
        	$model->emails = Receptoresemails::removeEmailsRepeat($model->mail, $model->emails);

        	$emails_validate = Receptoresemails::validateEmails($model->emails);

        	if ($emails_validate === true) {
        		
	        	if ($model->save()) {
	        		
	        		// si el usuario modificó los emails se guardan los cambios
		        	if (!Receptoresemails::isEmailsArrayEquals($model->emails, $model->emailsCopy)) {
		        		Receptoresemails::saveEmailsArray($id, $model->emails);
		        	}
		        	
		        	return $this->redirect(['view', 'id' => $model->receptorid]);
	        	}
	        	
        	}
        	else {
        		Yii::$app->getSession()->setFlash('danger', 'El Email <b>"'. $emails_validate .'"</b> no es válido.');
        	}
        	
        } 
         
                
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Receptores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        #$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Receptores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receptores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$this->isGuestGoHome();

    	// se asegura que el receptor pertenezca a la empresa
    	$query = Receptores::find()->joinWith('empresasreceptores')
    	->where(['empresasreceptores.empresaid'=>Yii::$app->user->identity->empresaid])
        ->andWhere(['receptores.empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['receptores.receptorid' => $id])
    	->asArray()
    	->one();
    	
		if ($query !== null) {
	        if (($model = Receptores::findOne($id)) !== null) {
	            return $model;
		}    	
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
    