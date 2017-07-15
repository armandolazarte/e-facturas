<?php

namespace backend\models;

use Yii;


class EmpresasAdmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresasadmin';
    }


    public static function isAdmin()
    {
    	$admin = self::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['empresauserid'=>Yii::$app->user->identity->id])->one();
    
    	if ($admin)
    		return true;
    	 
    	return false;
    
    }    

    public static function isEmpresaAdmin()
    {
        $admin = self::find()
        ->where(['empresaid'=>Yii::$app->user->identity->empresaid])
        ->one();
    
        if ($admin)
            return true;
    
        return false;
    
    }    
    
    
    public static function getPasswordAdmin()
    {
    	$admin = self::find()->one();
    
    	if ($admin)
    		return $admin->password;
    
    	return false;
    
    }
}
