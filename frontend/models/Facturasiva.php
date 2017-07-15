<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "facturasiva".
 *
 * @property string $facturaivaid
 * @property string $facturaid
 * @property string $ivaid
 * @property double $baseimponible
 * @property double $importe
 *
 * @property Facturasenc $factura
 * @property Alicuotasivafe $iva
 */
class Facturasiva extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturasiva';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid'], 'required'],
            [['facturaid', 'ivaid'], 'integer'],
            [['baseimponible', 'importe'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facturaivaid' => 'Facturaivaid',
            'facturaid' => 'Facturaid',
            'ivaid' => 'Ivaid',
            'baseimponible' => 'Baseimponible',
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
    public function getIva()
    {
        return $this->hasOne(Alicuotasivafe::className(), ['ivaid' => 'ivaid']);
    }
}
