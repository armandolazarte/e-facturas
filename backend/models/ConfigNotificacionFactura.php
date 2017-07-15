<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "config_notificacion_factura".
 *
 * @property string $empresaid
 * @property boolean $permite_msg_adicional
 * @property boolean $alert_actualizacion_visto
 */
class ConfigNotificacionFactura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_notificacion_factura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid'], 'required'],
            [['empresaid'], 'integer'],
            [['permite_msg_adicional', 'alert_actualizacion_visto'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
            'permite_msg_adicional' => 'Permite Msg Adicional',
            'alert_actualizacion_visto' => 'Alert Actualizacion Visto',
        ];
    }
    
    public static function createConfigEmpresaDefault()
    {
    	$existe = ConfigNotificacionFactura::getConfigEmpresa();
    	
    	if ($existe === null) {
    	
	    	$model = new ConfigNotificacionFactura();
	    	$model->empresaid = Yii::$app->user->identity->empresaid;
	    	$model->save();

    	}
    
    }
    
    public static function getConfigEmpresa()
    {
	    $model = ConfigNotificacionFactura::find()
		    ->where(['empresaid'=>Yii::$app->user->identity->empresaid])
		    ->one();
    
	    return $model;
    }    
    
    public static function updateConfigEmpresa($campo, $valor)
    {
    	$valor = Html::encode($valor);
    	
    	$model = ConfigNotificacionFactura::getConfigEmpresa();
    	
    	if ($model === null) {
    		ConfigNotificacionFactura::createConfigEmpresaDefault();
    		$model = ConfigNotificacionFactura::getConfigEmpresa();
    	}
    	
    	if ($campo === 'permite_msg_adicional') {
	    	$model->permite_msg_adicional = $valor; 
    	}
    	
    	else if ($campo === 'alert_actualizacion_visto') {
    		$model->alert_actualizacion_visto = $valor;
    	}
    	
    	
    	$model->save();
    	
    }
}
