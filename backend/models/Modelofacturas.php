<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "modelofactura".
 *
 * @property string $modeloid
 * @property string $puntoventaid
 * @property string $empresaid
 * @property string $file
 * @property integer $modelo
 */
class Modelofacturas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modelofactura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puntoventaid', 'empresaid', 'file', 'modelo'], 'required'],
            [['puntoventaid', 'empresaid', 'modelo'], 'integer'],
            [['file'], 'string', 'max' => 8000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'modeloid' => 'Modeloid',
            'puntoventaid' => 'Puntoventaid',
            'empresaid' => 'Empresaid',
            'file' => 'File',
            'modelo' => 'Modelo',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntoventa()
    {
    	return $this->hasOne(Puntosventa::className(), ['puntoventaid' => 'puntoventaid']);
    }
}
