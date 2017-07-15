<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "empresasreceptores".
 *
 * @property integer $empresareceptorid
 * @property integer $empresaid
 * @property integer $receptorid
 * @property string $fechavinculacion
 *
 * @property Empresas $empresa
 * @property Receptores $receptor
 */
class Empresasreceptores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresasreceptores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'receptorid', 'fechavinculacion'], 'required'],
            [['empresaid', 'receptorid'], 'integer'],
            [['fechavinculacion'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresareceptorid' => 'Empresareceptorid',
            'empresaid' => 'Empresaid',
            'receptorid' => 'Receptorid',
            'fechavinculacion' => 'Fechavinculacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['empresaid' => 'empresaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptor()
    {
        return $this->hasOne(Receptores::className(), ['receptorid' => 'receptorid']);
    }
}
