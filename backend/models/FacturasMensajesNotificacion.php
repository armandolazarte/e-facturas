<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "facturas_mensajes_notificacion".
 *
 * @property string $facturaid
 * @property string $mensajeid
 *
 * @property MensajesNotificacionFacturas $mensaje
 */
class FacturasMensajesNotificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturas_mensajes_notificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid', 'mensajeid'], 'required'],
            [['facturaid', 'mensajeid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facturaid' => 'Facturaid',
            'mensajeid' => 'Mensajeid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasOne(MensajesNotificacionFacturas::className(), ['mensajeid' => 'mensajeid']);
    }
    

    public static function getMensajeByFacturaid($facturaid)
    {
    	$query = FacturasMensajesNotificacion::find()
		    	->joinWith('mensajes')
		    	->where(['empresaid' => Yii::$app->user->identity->empresaid])
		    	->andWhere(['facturaid' => $facturaid])
		    	->asArray()
		    	->all();
    
    	if (isset($query[0]['mensajes']['mensaje'])) {
    		return $query[0]['mensajes']['mensaje'];
    	}
    
    	 
    	return null;
    }
}
