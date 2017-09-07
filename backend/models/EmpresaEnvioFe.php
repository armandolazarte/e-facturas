<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;


class EmpresaEnvioFe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_envio_fe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid'], 'required'],
            [['empresaid'], 'integer'],
            [['status'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
            'status' => 'status',
        ];
    }
    
    public static function createConfigEmpresaDefault()
    {
    	$existe = EmpresaEnvioFe::getConfigEmpresa();
    	
    	if ($existe === null) {
    	
	    	$model = new EmpresaEnvioFe();
	    	$model->empresaid = Yii::$app->user->identity->empresaid;
	    	$model->save();

    	}
    
    }
    
    public static function getConfigEmpresa()
    {
	    $model = EmpresaEnvioFe::find()
		    ->where(['empresaid'=>Yii::$app->user->identity->empresaid])
		    ->one();
    
	    return $model;
    }    
    
    /*
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
    */
}
