<?php

namespace backend\models;

use Yii;


class FacturasVistaPublica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturasvistapublica';
    }


    /**
     * 
     */
    public static function generateKey()
    {
//     	$str = 'JrQPsThuJteNfHGjLlHgVo95fV6LjBNVLi7AuH';
//     	$array = str_split($str . $str . $str);
//     	shuffle($array);
//     	$string = implode('',$array);
// 		$hash = hash('sha256', $string);

    	$randomString = Yii::$app->security->generateRandomString() . Yii::$app->security->generateRandomString();
    	$hash = hash('sha256', $randomString);
    	
        return $hash;
    }
    
    
    /**
     * 
     */
    public static function isHash($key)
    {
    	$sha256_MATCH = '/^[a-f0-9]{64}$/i';
    	
	    if(preg_match($sha256_MATCH, $key))
	    	return true;
	    
	    return false;
    }

    /**
     * 
     */
    private static function getView($id)
    {
    	return self::find()->where(['facturaid'=>$id])->one();
    }
    
    
    /**
     *
     */
    private static function createView($id) {
    	
    	$model = new FacturasVistaPublica();

    	$model->facturaid = $id;
    	$model->key = self::generateKey();
    	
    	$model->save();
    	
    }
    
    /**
     * 
     * getKeyView recibe como parametro el id de la factura
     * devuelve un hash asociado a esa factura para que un usuario publico 
     * pueda ver la factura sin estar registrado.
     * 
     * si la factura tiene un hash asociado se retorna ese valor,
     * si no lo tiene se crea uno.
     * 
     */
    public static function getKeyView($id) {
    
    	$view = self::getView($id);
    
    	if ($view == null) {
    		self::createView($id);
    		$view = self::getView($id);
    	}
    	 
    	return $view->key;
    }
    
}
