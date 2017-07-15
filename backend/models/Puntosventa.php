<?php

namespace backend\models;

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
            ['puntoventa', 'required', 'message' => 'El punto de venta es un campo requerido.'],
            [['fecha', 'empresaid'], 'safe'],
            ['puntoventa', 'string', 'max' => 10, 'message' => 'El punto de venta no debe superar los 10 caracteres.'],
            ['descripcion', 'string', 'max' => 100, 'message' => 'La descripcion no debe superar los 100 caracteres.']
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
            'puntoventa' => 'Punto Venta',
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
}
