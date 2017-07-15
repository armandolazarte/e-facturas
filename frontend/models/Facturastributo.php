<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "facturastributo".
 *
 * @property string $facturatributoid
 * @property string $facturaid
 * @property string $tributoid
 * @property string $descripcion
 * @property double $baseimponible
 * @property double $alicuota
 * @property double $importe
 *
 * @property Facturasenc $factura
 * @property Tributosfe $tributo
 */
class Facturastributo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturastributo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid'], 'required'],
            [['facturaid', 'tributoid'], 'integer'],
            [['baseimponible', 'alicuota', 'importe'], 'number'],
            [['descripcion'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facturatributoid' => 'Facturatributoid',
            'facturaid' => 'Facturaid',
            'tributoid' => 'Tributoid',
            'descripcion' => 'Descripcion',
            'baseimponible' => 'Baseimponible',
            'alicuota' => 'Alicuota',
            'importe' => 'Importe',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactura()
    {
        return $this->hasOne(Facturasenc::className(), ['facturaid' => 'facturaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTributo()
    {
        return $this->hasOne(Tributosfe::className(), ['tributoid' => 'tributoid']);
    }
}
