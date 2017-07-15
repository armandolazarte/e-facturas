<?php

namespace backend\models;

use Yii;


/**
 * This is the model class for table "receptores".
 *
 * @property integer $receptorid
 * @property integer $documentoid
 * @property string $cuit
 * @property string $nombre
 * @property string $direccion
 * @property string $localidad
 * @property integer $provinciaid
 * @property integer $responsableid
 * @property string $telefono
 * @property string $mail
 *
 * @property Empresasreceptores[] $empresasreceptores
 * @property Facturasenc[] $facturasencs
 * @property Tiporesponsablefe $responsable
 */
class Receptores extends \yii\db\ActiveRecord
{
	
	public $emails = [];
	public $emailsCopy = [];
	public $filtro_principal = 'TODOS';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'receptores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['documentoid', 'provinciaid', 'responsableid'], 'integer'],
            [['cuit'], 'string', 'max' => 13],
			[['emails','filtro_principal'], 'safe'],
			[['mail'], 'email','message' => 'El Email Principal no es válido.'],
            [['nombre', 'direccion', 'localidad', 'telefono', 'mail'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'receptorid' => 'Receptorid',
            'documentoid' => 'Documentoid',
            'cuit' => 'Cuit',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'localidad' => 'Localidad',
            'provinciaid' => 'Provinciaid',
            'responsableid' => 'Responsableid',
            'telefono' => 'Telefono',
            'mail' => 'Email Principal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresasreceptores()
    {
        return $this->hasMany(Empresasreceptores::className(), ['receptorid' => 'receptorid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptoresemails()
    {
    	return $this->hasMany(Receptoresemails::className(), ['receptorid' => 'receptorid']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasencs()
    {
        return $this->hasMany(Facturasenc::className(), ['receptorid' => 'receptorid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsables()
    {
        return $this->hasMany(Tiporesponsablefe::className(), ['responsableid' => 'responsableid']);
    }
    
    /*
    public static function getEmail($receptorid)
    {
        $email = Receptores::find()->where(['receptorid'=>$receptorid])->one();

        if ($email !== null && $email !== '') {

        }


        return $email;
    }  
    */  
    
    
    
}
