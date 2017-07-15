<?php

namespace backend\models;

use Yii;
use backend\models\FacturasMensajesNotificacion;

/**
 * This is the model class for table "mensajes_notificacion_facturas".
 *
 * @property string $mensajeid
 * @property string $empresaid
 * @property string $mensaje
 *
 * @property FacturasMensajesNotificacion[] $facturasMensajesNotificacions
 */
class MensajesNotificacionFacturas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensajes_notificacion_facturas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'mensaje'], 'required'],
            [['empresaid'], 'integer'],
            [['mensaje'], 'string', 'max' => 8192]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mensajeid' => 'Mensajeid',
            'empresaid' => 'Empresaid',
            'mensaje' => 'Mensaje',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturasMensajesNotificacions()
    {
        return $this->hasMany(FacturasMensajesNotificacion::className(), ['mensajeid' => 'mensajeid']);
    }
    
    
    
    
    public static function saveMensaje($facturaid, $mensaje)
    {
    	$model = FacturasMensajesNotificacion::find()->where(['facturaid'=>$facturaid])->one();

    	if ($model === null) {
    		
    		if ($mensaje === null || $mensaje === "") {
    			return false;
    		}    		
    		
			MensajesNotificacionFacturas::insertMensaje($facturaid, $mensaje);
    	}
    	else {
    		
    		if ($mensaje === null || $mensaje === "") {
    			MensajesNotificacionFacturas::deleteMensaje($model);
    			return false;
    		}
    		    		
    		MensajesNotificacionFacturas::updateMensaje($model->mensajeid, $mensaje);
    		
    	}
    	
		return true;
    }    
    
    private static function insertMensaje($facturaid, $mensaje)
    {
	    $model_1 = new MensajesNotificacionFacturas();
	    $model_1->empresaid = Yii::$app->user->identity->empresaid;
	    $model_1->mensaje = $mensaje;
	    $model_1->save();

	    $model_2 = new FacturasMensajesNotificacion();
	    $model_2->facturaid = $facturaid;
	    $model_2->mensajeid = $model_1->mensajeid;
	    $model_2->save();
    }
    
    private static function updateMensaje($mensajeid, $mensaje)
    {
    	$model = MensajesNotificacionFacturas::find()
	    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
	    	->andWhere(['mensajeid'=>$mensajeid])
	    	->one();
    	
    	$model->mensaje = $mensaje;
    	$model->save();    	
    }    

    
    private static function deleteMensaje($model)
    {
    	$mensajeid = $model->mensajeid;
    	
    	$model->delete();
    	
    	$model_1 = MensajesNotificacionFacturas::find()
	    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
	    	->andWhere(['mensajeid'=>$mensajeid])
	    	->one();
    	 
		$model_1->delete();
    }
    
}
