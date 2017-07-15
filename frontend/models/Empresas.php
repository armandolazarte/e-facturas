<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "empresas".
 *
 * @property string $empresaid
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
 *
 * @property Archivos[] $archivos
 * @property Comprobantesenvio[] $comprobantesenvios
 * @property Configuracionservicios[] $configuracionservicios
 * @property Conceptosfe $prestador
 * @property Provinciasfe $provincia
 * @property Tiporesponsablefe $responsable
 * @property Empresasreceptores[] $empresasreceptores
 * @property Facturasenc[] $facturasencs
 * @property Mails[] $mails
 * @property Puntosventa[] $puntosventas
 * @property Usuarios[] $usuarios
 */
class Empresas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nrocuit'], 'required'],
            [['inicioact', 'fechabaja'], 'safe'],
            [['prestadorid', 'responsableid', 'provinciaid', 'cuponpf', 'cuitasociado'], 'integer'],
            [['nrocuit'], 'string', 'max' => 11],
            [['razonsocial', 'calle', 'localidad', 'telefono', 'url'], 'string', 'max' => 255],
            [['nroiibb', 'gln'], 'string', 'max' => 13],
            [['nro', 'piso', 'depto', 'manzana'], 'string', 'max' => 6],
            [['cp'], 'string', 'max' => 8],
            [['sector', 'torre'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
            'nrocuit' => 'Nrocuit',
            'razonsocial' => 'Razonsocial',
            'nroiibb' => 'Nroiibb',
            'inicioact' => 'Inicioact',
            'prestadorid' => 'Prestadorid',
            'responsableid' => 'Responsableid',
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivos()
    {
        return $this->hasMany(Archivos::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobantesenvios()
    {
        return $this->hasMany(Comprobantesenvio::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracionservicios()
    {
        return $this->hasMany(Configuracionservicios::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestador()
    {
        return $this->hasOne(Conceptosfe::className(), ['conceptoid' => 'prestadorid']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresasreceptores()
    {
        return $this->hasMany(Empresasreceptores::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasencs()
    {
        return $this->hasMany(Facturasenc::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMails()
    {
        return $this->hasMany(Mails::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntosventas()
    {
        return $this->hasMany(Puntosventa::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['empresaid' => 'empresaid']);
    }
}
