<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tiporesponsablefe".
 *
 * @property string $responsableid
 * @property string $codigo
 * @property string $responsable
 *
 * @property Empresas[] $empresas
 * @property Facturasenc[] $facturasencs
 * @property Receptores[] $receptores
 */
class Tiporesponsablefe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tiporesponsablefe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'responsable'], 'required'],
            [['codigo'], 'string', 'max' => 20],
            [['responsable'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'responsableid' => 'Responsableid',
            'codigo' => 'Codigo',
            'responsable' => 'Responsable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresas::className(), ['responsableid' => 'responsableid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasencs()
    {
        return $this->hasMany(Facturasenc::className(), ['responsableid' => 'responsableid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptores()
    {
        return $this->hasMany(Receptores::className(), ['responsableid' => 'responsableid']);
    }
}
