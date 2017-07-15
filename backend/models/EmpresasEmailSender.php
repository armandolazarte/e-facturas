<?php

namespace backend\models;

use Yii;
use common\models\Formato;

/**
 * This is the model class for table "empresasemailsender".
 *
 * @property string $empresaid
 * @property string $nombre
 * @property string $email
 * @property string $password
 * @property string $hash_validate
 * @property integer $status
 */
class EmpresasEmailSender extends \yii\db\ActiveRecord
{
	public $passwordold;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresasemailsender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        		[['nombre', 'email', 'servidor_smpt', 'puerto_smpt'], 'filter', 'filter' => 'trim'],
        		[['email', 'servidor_smpt'], 'filter', 'filter' => 'strtolower'],

        		[['servidor_smpt'], 'required','message' => 'El servidor SMTP es un campo requerido.'],
        		[['puerto_smpt'], 'required','message' => 'El puerto SMTP es un campo requerido.'],
        		[['email'], 'required','message' => 'El email es un campo requerido.'],
        		[['nombre'], 'required','message' => 'El nombre es un campo requerido.'],
        		[['password'], 'required','message' => 'Debe ingresar el password del email declarado.'],
        		[['passwordold'], 'required','message' => 'El password actual es un campo requerido.'],

        		[['email'], 'email', 'message' => 'El formato del email no es correcto.'],        		

        		[['puerto_smpt'], 'integer','message' => 'El puerto SMTP debe ser numerico.'],
        		
        		[['nombre'], 'string', 'min' => 4, 'max' => 100],
        		[['email'], 'string', 'min' => 10, 'max' => 100],
        		[['servidor_smpt'], 'string', 'min' => 10, 'max' => 50],
        		[['puerto_smpt'], 'string', 'min' => 2, 'max' => 5],
	            [['password'], 'string', 'min' => 6, 'max' => 50],
        		[['passwordold'], 'string', 'min' => 6, 'max' => 16],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
			'servidor_smpt' => 'Servidor SMTP',
        	'puerto_smpt' => 'Puerto SMTP',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'password' => 'Password Email',
			'passwordold' => 'Password Actual',
            'hash_validate' => 'Hash Validate',
            'status' => 'Estado',
        ];
    }
    
    
    public static function generateHash()
    {
    	$randomString = Yii::$app->security->generateRandomString() . Yii::$app->security->generateRandomString();
    	$hash = hash('sha256', $randomString);
    	 
    	return $hash;
    }    
    
    
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateNotificar()
    {
    	 
		$user = User::findIdentity(Yii::$app->user->id);
    	if ($user->validatePassword($this->passwordold)) {

    		$this->hash_validate = self::generateHash();
    		$this->status = 0;
    		
    		
    		$this->nombre = Formato::tildesToHtmlEntities($this->nombre);
    		
			if ($this->save()) {
				// todo ok.
    			return $user;
    		}
    		else {
    			// no se pudieron guardar los cambios
    			return null;
    		}
    		
    	}

    	// la pass no es valida
    	return false;
    }

    
    public function sendEmailValidation()
    {
    	$linkValidation = Yii::$app->urlManager->createAbsoluteUrl(
    			[
					'empresas-email-sender/validate-email-acount',
					'id' => Yii::$app->user->identity->empresaid,
					'token' => $this->hash_validate
    			]
    	);


        /*
        if (Yii::$app->user->identity->empresaid == 41) {
            echo '<br><br><br><br><br>';

            echo '<br><br>';
            echo '['. $this->servidor_smpt .']';
            echo '<br><br>';
            echo '['. $this->email .']';
            echo '<br><br>';
            echo '['. $this->password .']';         
            echo '<br><br>';
            echo '['. $this->puerto_smpt .']';         
            exit();
        }
        */

    	
    	$mailer = Yii::$app->mailer;

    	$transporte = [

    			'class' => 'Swift_SmtpTransport',
    			'host' => trim($this->servidor_smpt), //'smtp.gmail.com',
    			'username' => trim($this->email),
    			'password' => $this->password,
    			'port' => trim($this->puerto_smpt),//'465',
    			'encryption' => 'tls',
    	];
    	
    	$mailer->setTransport($transporte);
    	
		$mailer->compose()
			->setFrom([$this->email => 'Airtech SA'])
	    	->setTo($this->email)
	    	->setSubject('Activar email en Airtech SA')
	    	->setHtmlBody('Active su cuenta de email para notificaciones desde el siguiente link <br>' . $linkValidation .'<br>'                )
	    	->send();



    	
    }

    
    public static function activateEmailAcount($id, $token)
    {
    	//  update($table, $columns, $conditions='', $params=array())
    	$query = Yii::$app->db->createCommand()->update(
    				self::tableName(), 
    				['status' => 1, 'hash_validate' => ''], 
    				'empresaid = :empresaid and hash_validate = :hash_validate', 
    				[':empresaid'=>$id, ':hash_validate'=>$token]
					)->execute();

    	if ($query) {
			return true;
    	}
    	
    	return false;
    	
    }
    
    
    public static function isHash($key)
    {
    	$sha256_MATCH = '/^[a-f0-9]{64}$/i';
    	 
    	if(preg_match($sha256_MATCH, $key))
    		return true;
    	 
    	return false;
    }
    
    public static function getEmailData($EMPRESA_ID) {
    	
	    $EMAIL_EMPRESA = self::find()
		    ->where(['empresaid'=>$EMPRESA_ID])
		    ->andWhere(['status'=>1])
		    ->one();
	    
	    if ($EMAIL_EMPRESA !== null) {
	    	return $EMAIL_EMPRESA;	    
	    }
	    else {
	    	return null;
	    }
    }
    
}
