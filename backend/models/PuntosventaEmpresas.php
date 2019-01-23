<?php

namespace backend\models;

use Yii;
use common\models\Formato;
use backend\models\EmpresasAdmin;

/**
 * This is the model class for table "puntosventa_empresas".
 *
 * @property string $empresaid
 * @property string $puntoventaid
 * @property string $nrocuit
 * @property string $razonsocial
 * @property string $nroiibb
 * @property string $inicioact
 * @property string $prestadorid
 * @property string $responsableid
 * @property string $calle
 * @property string $nro
 * @property string $piso
 * @property string $depto
 * @property string $cp
 * @property string $manzana
 * @property string $localidad
 * @property string $sector
 * @property integer $provinciaid
 * @property string $torre
 * @property string $telefono
 * @property string $url
 * @property integer $cuponpf
 * @property string $gln
 * @property string $fechabaja
 * @property integer $cuitasociado
 * @property string $email
 */
class PuntosventaEmpresas extends \yii\db\ActiveRecord
{
	public $passwordold;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'puntosventa_empresas';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
//         return [
//             [['empresaid', 'puntoventaid'], 'required'],
//             [['empresaid', 'puntoventaid', 'prestadorid', 'responsableid', 'provinciaid', 'cuponpf', 'cuitasociado'], 'integer'],
//             [['inicioact', 'fechabaja', 'email'], 'safe'],
//             [['nrocuit'], 'string', 'max' => 11],
//             [['razonsocial', 'calle', 'localidad', 'telefono', 'url', 'email'], 'string', 'max' => 100],
//             [['nroiibb', 'gln'], 'string', 'max' => 13],
//             [['nro', 'piso', 'depto', 'manzana'], 'string', 'max' => 6],
//             [['cp'], 'string', 'max' => 8],
//             [['sector', 'torre'], 'string', 'max' => 5]
//         ];
//     }
    public function rules()
    {
    	return [
    			[['empresaid', 'puntoventaid'], 'required'],

    			['razonsocial', 'filter', 'filter' => 'trim'],
    			['razonsocial', 'string', 'min' => 3],
    			['razonsocial', 'string', 'max' => 100],
    			['razonsocial', 'required', 'message' => 'La Razon Social es un campo requerido.'],

    			['nroiibb', 'filter', 'filter' => 'trim'],
    			['nroiibb', 'string', 'max' => 15],
    			['nroiibb', 'required', 'message' => 'El Nro IIBB es un campo requerido.'],

    			['calle', 'filter', 'filter' => 'trim'],
    			['calle', 'string', 'min' => 3],
    			['calle', 'required', 'message' => 'La Calle es un campo requerido.'],

    			['piso', 'filter', 'filter' => 'trim'],
//     			['piso', 'integer', 'integerOnly'=>true, 'message' => 'Solo se admiten numeros.'],

    			['nro', 'filter', 'filter' => 'trim'],
    			['nro', 'integer', 'integerOnly'=>true, 'message' => 'Solo numeros.'],
    			['nro', 'required', 'message' => 'El Nro es requerido.'],

    			['cp', 'filter', 'filter' => 'trim'],
    			['cp', 'string', 'max' => 8],
//    			['cp', 'integer', 'integerOnly'=>true, 'message' => 'Solo numeros.'],

    			['depto', 'filter', 'filter' => 'trim'],
//     			['depto', 'string', 'min' => 1],
//     			['depto', 'string', 'max' => 3],

    			['localidad', 'filter', 'filter' => 'trim'],
    			['localidad', 'string', 'min' => 4],
    			['localidad', 'required', 'message' => 'La Localidad es un campo requerido.'],

    			['telefono', 'filter', 'filter' => 'trim'],
    			['telefono', 'string', 'max' => 50],

    			['email', 'filter', 'filter' => 'trim'],
    			['email', 'email', 'message' => 'El formato del email no es correcto.'],
    			['email', 'string', 'min' => 6, 'max' => 80],

    			['url', 'filter', 'filter' => 'trim'],
    			['url', 'string', 'min' => 6, 'max' => 80],

//     			['prestadorid', 'integer', 'integerOnly'=>true, 'min' => 1],
//     			['prestadorid', 'required', 'message' => 'Prestador es un campo requerido.'],

//     			['responsableid', 'integer', 'integerOnly'=>true, 'min' => 1],
//     			['responsableid', 'required', 'message' => 'Responsable tipo es un campo requerido.'],

//     			['passwordold', 'string', 'min' => 6, 'max' => 15],
//     			['passwordold', 'required', 'message' => 'Debe ingresar su password actual'],

// //     			['inicioact', 'date', 'format'=>'yyyy-mm-dd'],
    			['inicioact', 'required', 'message' => 'La fecha de Inicio de Actividad es un campo requerido.'],

    			['nrocuit', 'filter', 'filter' => 'trim'],
    			['nrocuit', 'required', 'message' => 'El CUIT es un campo requerido.'],
    			['nrocuit', 'integer', 'message' => 'El CUIT debe ser numerico.'],
    			['nrocuit', 'string', 'min' => 11],

    			[['fechabaja', 'prestadorid', 'responsableid', 'provinciaid', 'gln', 'cuponpf', 'cuitasociado', 'manzana', 'sector', 'torre'], 'safe'],

//     			//     			['cuit', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
    	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
            'puntoventaid' => 'Puntoventaid',
            'nrocuit' => 'Nrocuit',
            'razonsocial' => 'Razonsocial',
            'nroiibb' => 'Nroiibb',
            'inicioact' => 'Inicioact',
            'prestadorid' => 'Prestadorid',
            'responsableid' => 'Responsableid',
						'responsable' => 'Responsable',
            'calle' => 'Calle',
            'nro' => 'Nro',
            'piso' => 'Piso',
            'depto' => 'Depto',
            'cp' => 'Cp',
            'manzana' => 'Manzana',
            'localidad' => 'Localidad',
            'sector' => 'Sector',
            'provinciaid' => 'Provinciaid',
            'torre' => 'Torre',
            'telefono' => 'Telefono',
            'url' => 'Url',
            'cuponpf' => 'Cuponpf',
            'gln' => 'Gln',
            'fechabaja' => 'Fechabaja',
            'cuitasociado' => 'Cuitasociado',
            'email' => 'Email',
        ];
    }

    public static function createPuntoVentaEmpresa($pvid)
    {

    	$query = Yii::$app->db->createCommand()
		    	->insert('puntosventa_empresas', [
		    	'empresaid' => Yii::$app->user->identity->empresaid,
		    	'puntoventaid' => $pvid,
	    	]);


    	if ($query->execute()){
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    public static function deletePuntoVentaEmpresa($pvid)
    {
    	$pvemp = self::find()
	    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
	    	->andWhere(['puntoventaid'=>$pvid])
    		->one();

    	if ($pvemp !== null){
    		if ($pvemp->delete()) {
	    		return true;
    		}
    	}

		return false;
    }

    public static function getDatosEmpresaJoinPuntoVenta($pvid)
    {
    	$datos = self::find()
    	->select('*')
    	->innerJoin('puntosventa')
			->innerJoin('Tiporesponsablefe')
    	->where(['puntosventa_empresas.empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['puntosventa_empresas.puntoventaid'=>$pvid])
    	->andWhere(['puntosventa.puntoventaid'=>$pvid])
    	->asArray()
    	->one();


    	if ($datos !== null) {
    		if ($datos['inicioact'] !== null) {
    			$datos['inicioact'] = explode(' ',$datos['inicioact'])[0];
    			$datos['inicioact'] = Formato::fechaSqlToDataPicker($datos['inicioact']);
    		}
    		return $datos;
    	}

    	return null;
    }

    public static function getPuntoVentaEmpresaById($id, $empresaid=null)
    {
        $pve = null;
        $empid = ($empresaid === null) ? Yii::$app->user->identity->empresaid : $empresaid;

        if ($empresaid === null) {
            if (EmpresasAdmin::isAdmin()) {
                $pve = self::find()->innerJoin('tiporesponsablefe')->andWhere(['puntoventaid'=>$id])->one();
            }
            else {
                $pve = self::find()->innerJoin('tiporesponsablefe')->where(['empresaid'=>$empid])->andWhere(['puntoventaid'=>$id])->one();

            }


        }
        else {
            $pve = self::find()->where(['empresaid'=>$empid])->andWhere(['puntoventaid'=>$id])->one();

        }


    	if ($pve !== null) {
    		if ($pve->inicioact !== null) {
		    	$pve->inicioact = explode(' ',$pve->inicioact)[0];
		    	$pve->inicioact = Formato::fechaSqlToDataPicker($pve->inicioact);
    		}
	    	return $pve;
    	}

    	return null;


    }

    public static function getArrayPuntoVentaEmpresaById($id)
    {
    	$pve = self::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['puntoventaid'=>$id])
    	->asArray()
    	->one();

    	return $pve;

    }

    public function updatePVE()
    {
		$pve = self::getPuntoVentaEmpresaById($this->puntoventaid);
		if ($pve === null) {
			return false;
		}

   		$pve->nrocuit = $this->nrocuit;
   		$pve->razonsocial = $this->razonsocial;
   		$pve->nroiibb = $this->nroiibb;
   		$pve->inicioact = Formato::fechaDataPickerToSql($this->inicioact);
   		$pve->prestadorid = $this->prestadorid;
   		$pve->responsableid = $this->responsableid;
   		$pve->calle = $this->calle;
   		$pve->nro = $this->nro;
   		$pve->piso = $this->piso;
   		$pve->depto = $this->depto;
   		$pve->cp = $this->cp;
   		$pve->localidad = $this->localidad;
   		$pve->provinciaid = $this->provinciaid;
   		$pve->telefono = $this->telefono;
   		$pve->url = $this->url;
   		$pve->email = $this->email;

   		if ($pve->save()) {
   			return true;
   		}

   		return false;

    }

}
