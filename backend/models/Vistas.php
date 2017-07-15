<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vistas".
 *
 * @property integer $id
 * @property string $descripcion
 */
class Vistas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vistas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
        ];
    }
    
    public static function getArrayVistas()
    {
    	return self::find()->asArray()->all();
    }    
    
    public static function getArrayVistaById($id)
    {
    	return self::find()->where(['id'=>$id])->one();
    }
}
