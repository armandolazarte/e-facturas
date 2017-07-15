<?php
namespace backend\models;

use backend\models\User;
use backend\models\Empresas;
use backend\models\EmpresaUser;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordrepeat;
    public $empresaid;
    public $cuit;
    public $verifyCode;
    private $_user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],            
            ['username', 'required','message' => 'El usuario es un campo requerido.'],
            ['username', 'unique', 'targetClass' => '\backend\models\User', 'message' => 'Este Nombre ya se encuentra registrado..'],            
            ['username', 'string', 'min' => 4, 'max' => 30],

            ['email', 'filter', 'filter' => 'trim'],
			['email', 'required','message' => 'El email es un campo requerido.'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\backend\models\User', 'message' => 'Este email ya se encuentra registrado.'],

            ['password', 'required','message' => 'El password es un campo requerido.'],
            ['password', 'string', 'min' => 6, 'max' => 20],

            ['passwordrepeat', 'required','message' => 'Debe repetir el password ingresado anteriormente.'],
            ['passwordrepeat', 'string', 'min' => 6, 'max' => 20],
            ['passwordrepeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Los Passwords no coinciden"],

			['cuit', 'filter', 'filter' => 'trim'],
			['cuit', 'required', 'message' => 'El CUIT es un campo requerido.'],
            ['cuit', 'integer', 'message' => 'El CUIT debe ser numerico.'],
			['cuit', 'string', 'min' => 11],
            #['empresaid', 'unique', 'targetClass' => '\backend\models\User', 'message' => 'el id es inexistente o este esta siendo utilizado por otro usuario.'],

            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
			'cuit' => 'CUIT',
			'username' => 'Usuario',
			'password' => 'Password',
			'passwordrepeat' => 'Repetir Password',
        ];
    }


    
    public function signup()
    {
        if ($this->validate()) {

        	$user = new User();
        	$user->username = $this->username;
        	$user->email = $this->email;
        	$user->setPassword($this->password);
        	$user->generateAuthKey();
        	 
        	//se obtiene la empresa a partir del cuit
        	$empresa = Empresas::getEmpresaByCuit($this->cuit);
        	 
        	// si la empresa existe ...
        	if ($empresa) {
	        	$user->empresaid = $empresa->empresaid;
        		// se chequea que no exista ningun usuario asociado a esa empresa
        		if (EmpresaUser::getEmpresaUserByEmpresaId($empresa->empresaid)) {
        			// si existe un usuario el registro (signup) se cancela
        			return false;
        		}
        	}
        	// sino... creamos la empresa
        	else {
        		self::generateEmpresa($this->cuit);

	        	$empresa = Empresas::getEmpresaByCuit($this->cuit);
	        	$user->empresaid = $empresa->empresaid;
        	}
        	
        	$this->_user = $user;
        	
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    
    
    protected static function generateEmpresa($cuit)
    {
    	$empresa = new Empresas();
    	$empresa->nrocuit = $cuit;
    	$empresa->save();    	
    }


    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
    	/* @var $user User */
    	$user = User::findOne([
    			'status' => User::STATUS_DELETED,
    			'email' => $this->email,
    	]);
    
    	if ($user) {
    		if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
    			$user->generatePasswordResetToken();
    		}
    
    		if ($user->save()) {
    			return \Yii::$app->mailer->compose(['text' => 'acountValidation-text'], ['user' => $user])
    			//->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
    			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
    			->setTo($this->email)
    			->setSubject('Confirm account for ' . \Yii::$app->name)
    			->send();
    		}
    	}
    
    	return false;
    }

}
