<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "facturasitem".
 *
 * @property string $facturaitemid
 * @property string $facturaid
 * @property string $codigo
 * @property string $descripcion
 * @property string $cantidad
 * @property string $unidadmedidaid
 * @property double $preciounitario
 * @property double $porcentajebonificacion
 * @property double $importebonificacion
 * @property double $subtotal
 * @property string $alicuotaiva
 * @property double $importeiva
 * @property string $glnproducto
 * @property double $importe
 * @property string $ivaid
 *
 * @property Facturasenc $factura
 * @property Alicuotasivafe $iva
 * @property Unidadesmedidafe $unidadmedida
 */
class Facturasitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturasitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid'], 'required'],
            [['facturaid', 'cantidad', 'unidadmedidaid', 'ivaid'], 'integer'],
            [['preciounitario', 'porcentajebonificacion', 'importebonificacion', 'subtotal', 'importeiva', 'importe'], 'number'],
            [['codigo', 'alicuotaiva'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 255],
            [['glnproducto'], 'string', 'max' => 13]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facturaitemid' => 'Facturaitemid',
            'facturaid' => 'Facturaid',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
            'cantidad' => 'Cantidad',
            'unidadmedidaid' => 'Unidadmedidaid',
            'preciounitario' => 'Preciounitario',
            'porcentajebonificacion' => 'Porcentajebonificacion',
            'importebonificacion' => 'Importebonificacion',
            'subtotal' => 'Subtotal',
            'alicuotaiva' => 'Alicuotaiva',
            'importeiva' => 'Importeiva',
            'glnproducto' => 'Glnproducto',
            'importe' => 'Importe',
            'ivaid' => 'Ivaid',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadmedida()
    {
        return $this->hasOne(Unidadesmedidafe::className(), ['unidadmedidaid' => 'unidadmedidaid']);
    }
}
