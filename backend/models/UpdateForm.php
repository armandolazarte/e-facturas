<?php
namespace backend\models;

use backend\models\User;
use backend\models\Empresas;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class UpdateForm extends Model
{
    public $empresaid;
    public $cuit;
    public $nombre;
    public $nroiibb;
    public $inicioact;
    public $calle;
    public $nro;
    public $piso;
    public $depto;
    public $cp;
    public $localidad;
    public $provincia;
    public $telefono;
    public $email;
    public $url;
    public $prestadorid;
    public $responsableid;
    public $password;
    public $passwordrepeat;
    public $passwordold;
    private $_user;
    private $_empresa;

    public function init(){
        $user = User::findIdentity(yii::$app->user->id);
        $empresa = Empresas::findOne($user->empresaid);
        $this->empresaid = '';
        $this->cuit = $empresa->nrocuit;
        $this->nombre = $empresa->razonsocial;
        $this->nroiibb = $empresa->nroiibb;
        $this->inicioact = $empresa->inicioact;
        $this->calle = $empresa->calle;
        $this->nro = $empresa->nro;
        $this->piso = $empresa->piso;
        $this->depto = $empresa->depto;
        $this->cp = $empresa->cp;
        $this->localidad = $empresa->localidad;
        $this->provincia = $empresa->provincia;
        $this->telefono = $empresa->telefono;
        $this->email = $empresa->email;
        $this->url = $empresa->url;
        $this->prestadorid = $empresa->prestadorid;
        $this->responsableid = $empresa->responsableid;
        $this->password = '';
        $this->passwordrepeat = '';
        $this->passwordold = '';
        $this->_user = $user;
        $this->_empresa = $empresa;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
        		
				['nombre', 'filter', 'filter' => 'trim'],
	            ['nombre', 'string', 'min' => 3],
				['nombre', 'string', 'max' => 150],
        		['nombre', 'required', 'message' => 'La Razon Social es un campo requerido.'],
        		
        		
				['nroiibb', 'filter', 'filter' => 'trim'],
    			['nroiibb', 'string', 'max' => 15],
	            ['nroiibb', 'required', 'message' => 'El Nro IIBB es un campo requerido.'],

        		['calle', 'filter', 'filter' => 'trim'],
	            ['calle', 'string', 'min' => 3],
        		['calle', 'required', 'message' => 'La Calle es un campo requerido.'],
        		
        		['piso', 'filter', 'filter' => 'trim'],
    	        ['piso', 'integer', 'integerOnly'=>true, 'message' => 'Solo se admiten numeros.'],
        		
        		['nro', 'filter', 'filter' => 'trim'],
        	    ['nro', 'integer', 'integerOnly'=>true, 'message' => 'Solo se admiten numeros.'],
        		['nro', 'required', 'message' => 'El Numero es un campo requerido.'],
        		
        		['cp', 'filter', 'filter' => 'trim'],
        		['cp', 'integer', 'integerOnly'=>true, 'message' => 'Solo se admiten numeros.'],

        		['depto', 'filter', 'filter' => 'trim'],
        		['depto', 'string', 'min' => 1],
        		['depto', 'string', 'max' => 3],
        		
        		['localidad', 'filter', 'filter' => 'trim'],
        		['localidad', 'string', 'min' => 6],
        		['localidad', 'required', 'message' => 'La Localidad es un campo requerido.'],
    			
    			['provincia', 'required', 'message' => 'La Provincia es un campo requerido.'],
    			
    			['telefono', 'filter', 'filter' => 'trim'],
    			['telefono', 'string', 'max' => 50],
    			
    			['email', 'filter', 'filter' => 'trim'],
    			['email', 'email', 'message' => 'El formato del email no es correcto.'],
    			['email', 'string', 'min' => 6, 'max' => 80],

                ['url', 'filter', 'filter' => 'trim'],
                ['url', 'string', 'min' => 6, 'max' => 50],

        		['prestadorid', 'integer', 'integerOnly'=>true, 'min' => 1],
        		['prestadorid', 'required', 'message' => 'Prestador es un campo requerido.'],

        		['responsableid', 'integer', 'integerOnly'=>true, 'min' => 1],
        		['responsableid', 'required', 'message' => 'Responsable tipo es un campo requerido.'],

        		['passwordold', 'string', 'min' => 6, 'max' => 15],
        		['passwordold', 'required', 'message' => 'Debe ingresar su password actual'],
            
        
//     			['password', 'required'],
//     			['password', 'string', 'min' => 6, 'max' => 15],

//     			['passwordrepeat', 'required'],
// 	            ['passwordrepeat', 'string', 'min' => 6, 'max' => 15],
// 	            ['passwordrepeat', 'compare', 'compareAttribute'=>'password', 'message'=>"La password no coincide"],

	            ['inicioact', 'date', 'format'=>'yyyy-mm-dd'],
	            ['inicioact', 'required', 'message' => 'La fecha de Inicio de Actividad es un campo requerido.'],
	
				['cuit', 'filter', 'filter' => 'trim'],
				['cuit', 'required', 'message' => 'El CUIT es un campo requerido.'],
	            ['cuit', 'integer', 'message' => 'El CUIT debe ser numerico.'],
				['cuit', 'string', 'min' => 11],
            

//     			['cuit', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    public function attributeLabels()
    {
        return [
	            'empresaid' => 'ID',
				'nombre' => 'Razon Social',
				'cp' => 'Codigo Postal',
        		'nroiibb' => 'Nro IIBB',
        		'cuit' => 'CUIT',
        		'nro' => 'Numero',
        		'provincia' => 'Provincia',
        		'telefono' => 'Telefono',
        		'email' => 'Email',
                'url' => 'Web',
        		'prestadorid' => 'Prestador',
        		'responsableid' => 'Responsable',
        		'inicioact' => 'Inicio Actividad',
// 	            'password' => 'Nueva Password',
// 	            'passwordrepeat' => 'Repetir Nueva Password',
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
            	
//                 if ($this->password) {
//                     $user->setPassword($this->password);
//                 }
                if ($empresa->nrocuit !== $this->cuit) {
                    $empresa->nrocuit = $this->cuit;
                }
                if ($empresa->razonsocial !== $this->nombre) {
                    $empresa->razonsocial = $this->nombre;
                }
                if ($empresa->nroiibb !== $this->nroiibb) {
                    $empresa->nroiibb = $this->nroiibb;
                }
                if ($empresa->inicioact !== $this->inicioact) {
                    $empresa->inicioact = $this->inicioact;
                }
                if ($empresa->calle !== $this->calle) {
                    $empresa->calle = $this->calle;
                }
                if ($empresa->nro !== $this->nro) {
                    $empresa->nro = $this->nro;
                }
                if ($empresa->piso !== $this->piso) {
                    $empresa->piso = $this->piso;
                }
                if ($empresa->depto !== $this->depto) {
                    $empresa->depto = $this->depto;
                }
                if ($empresa->cp !== $this->cp) {
                    $empresa->cp = $this->cp;
                }
                if ($empresa->localidad !== $this->localidad) {
                    $empresa->localidad = $this->localidad;
                }
                if ($empresa->provinciaid !== $this->provincia) {
                	$empresa->provinciaid = $this->provincia;
                }
                if ($empresa->telefono !== $this->telefono) {
                	$empresa->telefono = $this->telefono;
                }
                if ($empresa->email !== $this->email) {
                	$empresa->email = $this->email;
                }

                if ($empresa->url !== $this->url) {
                    $empresa->url = $this->url;
                }
                if ($empresa->responsableid !== $this->responsableid) {
                    $empresa->responsableid = $this->responsableid;
                }
                if ($empresa->prestadorid !== $this->prestadorid) {
                    $empresa->prestadorid = $this->prestadorid;
                } 
                $this->_user = $user;
                $this->_empresa = $empresa;
                if ($empresa->save()) {
                    return $empresa;
                }
                if ($user->save()) {
                    return $user;
                }
            }
        }
        return null;
    }
}
