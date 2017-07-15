<?php

namespace frontend\models;

use Yii;
use backend\models\FacturasMensajesNotificacion;

/**
 * This is the model class for table "facturasenc".
 *
 * @property string $facturaid
 * @property string $empresaid
 * @property string $receptorid
 * @property string $puntoventa
 * @property string $comprobanteid
 * @property string $comprobantenro
 * @property string $letra
 * @property string $fechafactura
 * @property string $clienteid
 * @property string $nombre
 * @property string $responsableid
 * @property string $direccion
 * @property string $localidad
 * @property integer $provinciaid
 * @property string $telefono
 * @property string $email
 * @property string $url
 * @property string $conceptoid
 *
 * @property Puntosventa $puntoventa0
 * @property Tipocomprobantefe $comprobante
 * @property Conceptosfe $concepto
 * @property Empresas $empresa
 * @property Provinciasfe $provincia
 * @property Receptores $receptor
 * @property Tiporesponsablefe $responsable
 * @property Facturasitem[] $facturasitems
 * @property Facturasiva[] $facturasivas
 * @property Facturaspie[] $facturaspies
 * @property Facturastributo[] $facturastributos
 */
class Facturasenc extends \yii\db\ActiveRecord
{

    public $query;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturasenc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'receptorid'], 'required'],
            [['empresaid', 'receptorid', 'puntoventa', 'comprobanteid', 'comprobantenro', 'responsableid', 'provinciaid', 'conceptoid'], 'integer'],
            [['fechafactura'], 'safe'],
            [['letra'], 'string', 'max' => 2],
            [['clienteid', 'nombre', 'direccion', 'localidad', 'telefono', 'email', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facturaid' => 'Facturaid',
            'empresaid' => 'Empresaid',
            'receptorid' => 'Receptorid',
            'puntoventa' => 'Puntoventa',
            'comprobanteid' => 'Comprobanteid',
            'comprobantenro' => 'Comprobantenro',
            'letra' => 'Letra',
            'fechafactura' => 'Fechafactura',
            'clienteid' => 'Clienteid',
            'nombre' => 'Nombre',
            'responsableid' => 'Responsableid',
            'direccion' => 'Direccion',
            'localidad' => 'Localidad',
            'provinciaid' => 'Provinciaid',
            'telefono' => 'Telefono',
            'email' => 'Email',
            'url' => 'Url',
            'conceptoid' => 'Conceptoid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntoventa0()
    {
        return $this->hasOne(Puntosventa::className(), ['puntoventaid' => 'puntoventa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobante()
    {
        return $this->hasOne(Tipocomprobantefe::className(), ['comprobanteid' => 'comprobanteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConcepto()
    {
        return $this->hasOne(Conceptosfe::className(), ['conceptoid' => 'conceptoid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincia()
    {
        return $this->hasOne(Provinciasfe::className(), ['provinciaid' => 'provinciaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptor()
    {
        return $this->hasOne(Receptores::className(), ['receptorid' => 'receptorid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsable()
    {
        return $this->hasOne(Tiporesponsablefe::className(), ['responsableid' => 'responsableid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasitems()
    {
        return $this->hasMany(Facturasitem::className(), ['facturaid' => 'facturaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasmensajesnotificacion()
    {
    	return $this->hasMany(FacturasMensajesNotificacion::className(), ['facturaid' => 'facturaid']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasivas()
    {
        return $this->hasMany(Facturasiva::className(), ['facturaid' => 'facturaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaspies()
    {
        return $this->hasMany(Facturaspie::className(), ['facturaid' => 'facturaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturastributos()
    {
        return $this->hasMany(Facturastributo::className(), ['facturaid' => 'facturaid']);
    }
}
