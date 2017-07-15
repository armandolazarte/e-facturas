<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "puntosventa".
 *
 * @property string $puntoventaid
 * @property string $empresaid
 * @property string $puntoventa
 * @property string $descripcion
 * @property string $fecha
 *
 * @property Comprobantesenvio[] $comprobantesenvios
 * @property Comprobantespuntosventa[] $comprobantespuntosventas
 * @property Facturasenc[] $facturasencs
 * @property Empresas $empresa
 */
class Puntosventa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'puntosventa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'puntoventa'], 'required'],
            [['empresaid'], 'integer'],
            [['fecha'], 'safe'],
            [['puntoventa'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'puntoventaid' => 'Puntoventaid',
            'empresaid' => 'Empresaid',
            'puntoventa' => 'Puntoventa',
            'descripcion' => 'Descripcion',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobantesenvios()
    {
        return $this->hasMany(Comprobantesenvio::className(), ['puntoventaid' => 'puntoventaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobantespuntosventas()
    {
        return $this->hasMany(Comprobantespuntosventa::className(), ['puntoventaid' => 'puntoventaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasencs()
    {
        return $this->hasMany(Facturasenc::className(), ['puntoventa' => 'puntoventaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['empresaid' => 'empresaid']);
    }
}
