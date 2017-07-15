<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "config_periodo_errores_fe".
 *
 * @property integer $empresaid
 * @property string $periodo
 */
class ConfigPeriodoErroresFe extends \yii\db\ActiveRecord
{
	
	public static $periodos = [
			1 => 'últimos 10 días',
			2 => 'último mes',
			3 => 'últimos 3 meses',
			4 => 'todos los errores',
	];
	
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_periodo_errores_fe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['periodo'], 'required'],
            [['empresaid'], 'safe'],
            [['periodo'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
            'periodo' => 'Periodo',
        ];
    }
    
    
    
    public static function getFechaDesdePeriodoFeError($periodo_int)
    {
    	
	    date_default_timezone_set('America/Argentina/Buenos_Aires');
	
	    // default 30 dias
	    $periodo = date('Ymd', strtotime(date('Ymd') . ' -30 day'));
	    
	    $periodo = ($periodo_int == 1) ? date('Ymd', strtotime(date('Ymd') . ' -10 day')) : $periodo ;
	    $periodo = ($periodo_int == 3) ? date('Ymd', strtotime(date('Ymd') . ' -90 day')) : $periodo ;
	    $periodo = ($periodo_int == 4) ? date('Ymd', strtotime(date('Ymd') . ' -10000 day')) : $periodo ;
	    
	    return $periodo;
    
    }
    
    public static function getPeriodoEmpresa($empresaid)
    {
    	
    	$query = ConfigPeriodoErroresFe::find()
	    	->where(['empresaid'=>$empresaid])
	    	->one();
    			
	    if ($query !== null) {
	    	return $query->periodo;
	    } 
	    else {
	    	// default 2, ultimo mes
	    	return 2;
	    }
    }
    
}
