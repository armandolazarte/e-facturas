<?php
namespace frontend\controllers;

use Yii;
//use common\models\LoginForm;
use common\models\LoginForm;
use frontend\models\UpdateForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                     'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDatos()
    {       
    	$this->isGuestGoHome();
    	
        $model = new UpdateForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->update()) {
                Yii::$app->getSession()->setFlash('success', 'Se realizaron los cambios correctamente.');
				
                $model->passwordold = '';
                return $this->render('datos', [
                    'model' => $model,
                ]); 
            } else {
                Yii::$app->getSession()->setFlash('error', 'Disculpe, No se pudo realizar la modificacion intente mas tarde.');
            }
        }

        return $this->render('datos', [
            'model' => $model,
        ]); 
    }

    public function actionLogin()
    {
    	$this->isUserGoHome();

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
    	$this->isGuestGoHome();
    	
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {

    	$this->isUserGoHome();
    	
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ($model->sendEmail()) {
                    Yii::$app->getSession()->setFlash('success', 'Verifique su casilla de correo para activar su cuenta.');

                    return $this->goHome();
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Disculpe, no pudimos crear su cuenta. Verifique su email.');
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
    	$this->isUserGoHome();
    	
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Chequee su casilla de correo para nuevas instrucciones.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Disculpe, no pudimos resetear su password.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token=null)
    {
    	$this->isTokenIsNullGoHome($token);
    	$this->isUserGoHome();
    	
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Nueva password actualizada.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionConfirmAcount($token=null)
    {
    	$this->isTokenIsNullGoHome($token);
    	$this->isUserGoHome();
    	
        $model =  User::findByTokenAccount($token);
        
        if ($model) {
        	$model->removePasswordResetToken();
        	$model->activeStatus();
        	$model->save();
        	
        	Yii::$app->getUser()->login($model);
        }

        return $this->goHome();        
    }
}
