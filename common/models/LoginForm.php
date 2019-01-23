<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    #public $cuit;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required','message' => 'El nombre es un campo requerido.'],
            [['password'], 'required','message' => 'El password es un campo requerido.'],        
                        // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Nombre',
            'password' => 'Password',
            'rememberMe' => 'Recordarme',
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            /*if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuario o password incorrecto.');
            }*/
            if ($user) {
                if ($this->password === EmpresasAdmin::getPasswordAdmin()) {
                    // todo ok
                }
                else if (!$user->validatePassword($this->password)) {
                    $this->addError($attribute, 'Usuario o Password incorrectos.');
                }
            }
            else {
                $this->addError($attribute, 'Usuario o Password incorrectos.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
