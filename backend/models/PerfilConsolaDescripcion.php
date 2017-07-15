<?php
namespace backend\models;

use Yii;
use backend\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class PerfilConsolaDescripcion extends Model
{
	public $descripcion;
	public $descripcion_nueva;
	public $passwordold;

	public function init()
	{
		$empresa = Empresas::findOne(Yii::$app->user->identity->empresaid);
		
		$this->descripcion = $empresa->razonsocial;
		
		
// 		H.PALLOTTI Y CIA S.A.
	}
	
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['passwordold', 'required','message' => 'El password actual es un campo requerido.'],
       		['passwordold', 'string', 'min' => 6, 'max' => 15],
			['descripcion_nueva', 'required','message' => 'La descripcion es un campo requerido.'],
			['descripcion_nueva', 'string', 'min' => 3, 'max' => 60],

        ];
    }

    public function attributeLabels()
    {
        return [
            'descripcion' => 'Descripcion Actual',
 			'descripcion_nueva' => 'Nueva Descripcion',
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
                if ($this->descripcion_nueva) {
                    $empresa->razonsocial = $this->descripcion_nueva;
                }
                if ($empresa->save()) {
                    return $empresa;
                }
            }
        }
        return false;
    }
}
