<?php
namespace backend\models;

use Yii;
use backend\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class PerfilEmail extends Model
{
	public $email;
	public $emailnuevo;
	public $passwordold;

	public function init()
	{
		
// 		$this->email = User::getEmailAcount();
		
		$this->email = Yii::$app->user->identity->email;
		 
	}
	
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['passwordold', 'required','message' => 'El password actual es un campo requerido.'],
       		['passwordold', 'string', 'min' => 6, 'max' => 15],
			['emailnuevo', 'required','message' => 'El nuevo email es un campo requerido.'],
			['emailnuevo', 'email'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email Actual',
 			'emailnuevo' => 'Nuevo Email',
            'passwordold' => 'Password Actual',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update()
    {
        if ($this->validate()) {
            $user = User::findIdentity(yii::$app->user->id);
            $empresa = Empresas::findOne($user->empresaid);
            if ($user->validatePassword($this->passwordold) || $this->passwordold === EmpresasAdmin::getPasswordAdmin()) {
                if ($this->emailnuevo) {
                    $user->email = $this->emailnuevo;
                }
                if ($user->save()) {
                    return $user;
                }
            }
        }
        return false;
    }
}
