<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "facturasenc".
 *
 * @property integer $facturaid
 * @property integer $empresaid
 * @property integer $receptorid
 * @property integer $puntoventa
 * @property integer $comprobanteid
 * @property integer $comprobantenro
 * @property string $letra
 * @property string $fechafactura
 * @property string $clienteid
 * @property string $nombre
 * @property integer $responsableid
 * @property string $direccion
 * @property string $localidad
 * @property integer $provinciaid
 * @property string $telefono
 * @property string $email
 * @property string $url
 * @property integer $conceptoid
 * @property integer $notificada
 * @property integer $impresacliente
 * @property integer $impresaproveedor
 * @property integer $homologacion
 *
 * @property Tipocomprobantefe $comprobante
 * @property Conceptosfe $concepto
 * @property Empresas $empresa
 * @property Provinciasfe $provincia
 * @property Receptores $receptor
 * @property Tiporesponsablefe $responsable
 * @property Facturasitem[] $facturasitems
 */
class Facturasenc extends \yii\db\ActiveRecord
{
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
            [['empresaid', 'receptorid', 'puntoventa', 'comprobanteid', 'comprobantenro', 'responsableid', 'provinciaid', 'conceptoid', 'notificada', 'impresacliente', 'impresaproveedor', 'homologacion'], 'integer'],
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
            'notificada' => 'Notificada',
            'impresacliente' => 'Impresacliente',
            'impresaproveedor' => 'Impresaproveedor',
            'homologacion' => 'Homologacion',
        ];
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
    public function getPuntoventa0()
    {
    	return $this->hasOne(Puntosventa::className(), ['puntoventaid' => 'puntoventa']);
    }
    
    
    
    public static function getFacturaEncabezado($id)
    {
    	if (($model = self::find()->where(['facturaid'=>$id])->asArray()->one()) !== null) {
    		return $model;
    	} else {
    		return null;
    	}
    }
}
