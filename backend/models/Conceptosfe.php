<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "conceptosfe".
 *
 * @property integer $conceptoid
 * @property string $codigo
 * @property string $descripcion
 *
 * @property Empresas[] $empresas
 * @property Facturasenc[] $facturasencs
 */
class Conceptosfe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conceptosfe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'conceptoid' => 'Conceptoid',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresas::className(), ['prestadorid' => 'conceptoid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasencs()
    {
        return $this->hasMany(Facturasenc::className(), ['conceptoid' => 'conceptoid']);
    }
}
