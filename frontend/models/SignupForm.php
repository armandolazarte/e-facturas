<?php
namespace frontend\models;

use common\models\User;
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
            ['username', 'required','message' => 'El nombre es un campo requerido.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El nombre ya se encuentra registrado.'],            
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
			['email', 'required','message' => 'El email es un campo requerido.'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El email ya se encuentra registrado.'],

            ['password', 'required','message' => 'El password es un campo requerido.'],
            ['password', 'string', 'min' => 6],

            ['passwordrepeat', 'required','message' => 'Debe repetir el password ingresado anteriormente.'],
            ['passwordrepeat', 'string', 'min' => 6],
            ['passwordrepeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Los Passwords no coinciden"],

			['cuit', 'filter', 'filter' => 'trim'],
			['cuit', 'required', 'message' => 'El CUIT es un campo requerido.'],
			['cuit', 'integer', 'message' => 'El CUIT debe ser numerico.'],
			['cuit', 'string', 'min' => 11],
            ['cuit', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El CUIT ya se encuentra registrado.'],

            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
			['verifyCode', 'required','message' => 'El captcha es un campo requerido.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Captcha',
			'cuit' => 'CUIT',
			'username' => 'Nombre',
			'password' => 'Password',
			'passwordrepeat' => 'Repetir Password',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->cuit = $this->cuit;
            $this->_user = $user;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
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
                    ->setSubject('Confirmar cuenta en ' . \Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }
}
