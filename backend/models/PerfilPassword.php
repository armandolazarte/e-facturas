<?php
namespace backend\models;

use Yii;
use backend\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class PerfilPassword extends Model
{
	public $password;
	public $passwordrepeat;
	public $passwordold;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['passwordold', 'required','message' => 'El password actual es un campo requerido.'],
       		['passwordold', 'string', 'min' => 6, 'max' => 15],
            ['password', 'required','message' => 'La nueva password es un campo requerido.'],
            ['password', 'string', 'min' => 6, 'max' => 15],
            ['passwordrepeat', 'required','message' => 'Debe repetir la nueva password.'],
            ['passwordrepeat', 'string', 'min' => 6, 'max' => 15],
            ['passwordrepeat', 'compare', 'compareAttribute'=>'password', 'message'=>"La password no coincide"],

        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Nueva Password',
            'passwordrepeat' => 'Repetir Nueva Password',
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
                if ($this->password) {
                    $user->setPassword($this->password);
                }
                if ($user->save()) {
                    return $user;
                }
            }
        }
        return false;
    }
}
