<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "estados_configuracion_fe".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $vista
 * @property integer $activo
 * @property string $estado
 */
class EstadosConfiguracionFe extends \yii\db\ActiveRecord
{
	
	public static $ESTADO_OK = 'OK';
	public static $ESTADO_NULL = 'NO';
	public static $ID_MISDATOS = 1;
	public static $ID_MODELOFACTURA = 2;
	public static $ID_PUNTOSVENTA = 3;
	public static $ID_SERVICIOS = 4;
	public static $ID_EMAILS = 5;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estados_configuracion_fe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['activo'], 'required'],
            [['activo'], 'integer'],
            [['titulo'], 'string', 'max' => 50],
            [['vista'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 10],
            [['vista'], 'unique'],
            [['titulo'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'vista' => 'Link',
            'activo' => 'Activo',
            'estado' => 'Estado',
        ];
    }
    
    
    public static function getEstadosArray()
    {
    	return self::find()    	
    	->andWhere(['activo'=>1])
    	->asArray()->all();
    }
    
    protected static function getEstadosById($id)
    {
    	return self::find()->where(['id'=>$id])->one();
    }
    
    
    public static function updateEstados($estados)
    {
    
    	$EMPRESA_ID = Yii::$app->user->identity->empresaid;
    
    	$estados = self::updateEstadosMISDATOS($EMPRESA_ID, $estados);
    	$estados = self::updateEstadosMODELOFACTURA($EMPRESA_ID, $estados);
    	$estados = self::updateEstadosPUNTOSVENTA($EMPRESA_ID, $estados);
    	$estados = self::updateEstadosSERVICIOS($EMPRESA_ID, $estados);
    	$estados = self::updateEstadosEMAILS($EMPRESA_ID, $estados);
    
    	
    	return $estados;
    
    }
    
    protected static function updateEstadosMISDATOS($EMPRESA_ID, $estados)
    {
    	$empresa = Empresas::find()->where(['empresaid'=>$EMPRESA_ID])->one();
    	//     	$datos_estado = self::getEstadosById(self::$ID_MISDATOS);
    	//     	$datos_estado->estado = ($empresa->razonsocial and $empresa->nroiibb) ? self::$ESTADO_OK : self::$ESTADO_NULL ;
    
    	$estados[self::$ID_MISDATOS - 1]['estado'] = self::$ESTADO_NULL ;
    
    	if ($empresa) {
    		if ($empresa->razonsocial) {
    			$estados[self::$ID_MISDATOS - 1]['estado'] = self::$ESTADO_OK;
    		}
    	}
    	 
    	//     	$datos_estado->save();
    	return $estados;
    	 
    }
    
    
    protected static function updateEstadosMODELOFACTURA($EMPRESA_ID, $estados)
    {
    	$modelo_empresa = ModeloFactura::getModeloFactura($EMPRESA_ID);
    	//     	$modelo_factura_estado = self::getEstadosById(self::$ID_MODELOFACTURA);
    	//     	$modelo_factura_estado->estado = self::$ESTADO_NULL;
    	$estados[self::$ID_MODELOFACTURA - 1]['estado'] = self::$ESTADO_NULL;
    	if ($modelo_empresa) {
    		if ($modelo_empresa->file != ModeloFactura::$RUTA_IMAGEN_ALTERNATIVA) {
    			$estados[self::$ID_MODELOFACTURA - 1]['estado'] = self::$ESTADO_OK;
    		}
    	}
    	//     	$modelo_factura_estado->save();
    	return $estados;
    }
    
    protected static function updateEstadosPUNTOSVENTA($EMPRESA_ID, $estados)
    {
    	$puntosventa = PuntosventaSearch::isPuntoVentaExist();
    	//     	$puntosventa_estado = self::getEstadosById(self::$ID_PUNTOSVENTA);
    	$estados[self::$ID_PUNTOSVENTA - 1]['estado'] = ($puntosventa) ? self::$ESTADO_OK : self::$ESTADO_NULL ;
    	//     	$puntosventa_estado->save();
    	return $estados;
    }
    
    
    protected static function updateEstadosSERVICIOS($EMPRESA_ID, $estados)
    {
    	$servicios = ConfiguracionserviciosSearch::isConfigServiciosEmpresaExist();
    	//     	$servicios_estado = self::getEstadosById(self::$ID_SERVICIOS);
    	$estados[self::$ID_SERVICIOS - 1]['estado'] = ($servicios) ? self::$ESTADO_OK : self::$ESTADO_NULL ;
    	//     	$servicios_estado->save();
    	return $estados;
    }
    
    protected static function updateEstadosEMAILS($EMPRESA_ID, $estados)
    {
    	$emails = MailsSearch::getMailsByEmpresa($EMPRESA_ID);
    	$estados[self::$ID_EMAILS - 1]['estado'] = ($emails) ? self::$ESTADO_OK : self::$ESTADO_NULL ;
    	//     	$servicios_estado->save();
    	return $estados;
    }
    
    
    
}
