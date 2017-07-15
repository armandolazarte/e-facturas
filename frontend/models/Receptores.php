<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "receptores".
 *
 * @property string $receptorid
 * @property integer $documentoid
 * @property string $cuit
 * @property string $nombre
 * @property string $direccion
 * @property string $localidad
 * @property integer $provinciaid
 * @property string $responsableid
 * @property string $telefono
 * @property string $mail
 *
 * @property Empresasreceptores[] $empresasreceptores
 * @property Facturasenc[] $facturasencs
 * @property Tipodocumentofe $documento
 * @property Provinciasfe $provincia
 * @property Tiporesponsablefe $responsable
 */
class Receptores extends \yii\db\ActiveRecord
{
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
            'mail' => 'Mail',
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
    public function getFacturasencs()
    {
        return $this->hasMany(Facturasenc::className(), ['receptorid' => 'receptorid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumento()
    {
        return $this->hasOne(Tipodocumentofe::className(), ['documentoid' => 'documentoid']);
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
    public function getResponsable()
    {
        return $this->hasOne(Tiporesponsablefe::className(), ['responsableid' => 'responsableid']);
    }

}
