<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class UpdateForm extends Model
{
    public $email;
    public $cuit;
    public $password;
    public $passwordrepeat;
    public $passwordold;
    private $_user;

    public function init(){
        $user = User::findIdentity(yii::$app->user->id);
        $this->email = $user->email;
        $this->cuit = $user->cuit;
        $this->password = '';
        $this->passwordrepeat = '';
        $this->passwordold = '';
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
//             ['email', 'required'],
            ['email', 'email'],

            ['passwordold', 'required'],
        	['passwordold', 'string', 'min' => 6, 'max' => 20],

            #['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 20],

            #['passwordrepeat', 'required'],
            ['passwordrepeat', 'string', 'min' => 6, 'max' => 20],
            ['passwordrepeat', 'compare', 'compareAttribute'=>'password', 'message'=>"La password no coincide"],

            ['cuit', 'filter', 'filter' => 'trim'],
            ['cuit', 'integer', 'message' => 'El CUIT debe ser numerico.'],
            ['cuit', 'string', 'min' => 11],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'cuit' => 'DNI/CUIT',
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
            if ($user->validatePassword($this->passwordold)) {
                if ($this->email) {
                    $user->email = $this->email;    
                }
                if ($this->password) {
                    $user->setPassword($this->password);
                }
                if ($this->cuit) {
                    $user->cuit = $this->cuit;
                }                
                $this->_user = $user;
                if ($user->save()) {
                    return $user;
                }
            }
        }
        return null;
    }
}

?>