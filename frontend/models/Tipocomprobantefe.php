<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tipocomprobantefe".
 *
 * @property string $comprobanteid
 * @property string $codigo
 * @property string $descripcion
 * @property string $a
 * @property string $b
 * @property integer $edi
 * @property string $letra
 *
 * @property Comprobantesenvio[] $comprobantesenvios
 * @property Comprobantespuntosventa[] $comprobantespuntosventas
 * @property Facturasenc[] $facturasencs
 */
class Tipocomprobantefe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipocomprobantefe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'descripcion'], 'required'],
            [['edi'], 'integer'],
            [['codigo'], 'string', 'max' => 20],
            [['descripcion', 'a', 'b', 'letra'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comprobanteid' => 'Comprobanteid',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
            'a' => 'A',
            'b' => 'B',
            'edi' => 'Edi',
            'letra' => 'Letra',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobantesenvios()
    {
        return $this->hasMany(Comprobantesenvio::className(), ['comprobanteid' => 'comprobanteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobantespuntosventas()
    {
        return $this->hasMany(Comprobantespuntosventa::className(), ['comprobante' => 'comprobanteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasencs()
    {
        return $this->hasMany(Facturasenc::className(), ['comprobanteid' => 'comprobanteid']);
    }
}
