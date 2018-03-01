<?php

namespace backend\models;

use Yii;


class ApiKey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apikey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','apikey'], 'required'],
            [['nombre'], 'string'],
            [['apikey'], 'string']
        ];
    }


    
    public static function getApiKey()
    {
	    $model = ApiKey::find()->one();
    
	    return $model;
    }    
    


}
