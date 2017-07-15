<?php

namespace backend\models;

use Yii;
use backend\models\VistasSearch;

/**
 * This is the model class for table "vistas_audita".
 *
 * @property string $id
 * @property string $empresaid
 * @property integer $vistaid
 * @property string $ultimo_ingreso
 * @property string $ingreso_anterior
 * @property integer $status
 * @property integer $contador
 *
 * @property Vistas $vista
 * @property Empresas $empresa
 */
class VistasAudita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vistas_audita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'vistaid', 'ultimo_ingreso', 'ingreso_anterior'], 'required'],
            [['empresaid', 'vistaid', 'status'], 'integer'],
            [['ultimo_ingreso', 'ingreso_anterior', 'contador'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empresaid' => 'Empresaid',
            'vistaid' => 'Vistaid',
            'ultimo_ingreso' => 'Ultimo Ingreso',
            'ingreso_anterior' => 'Ingreso Anterior',
            'status' => 'Status',
			'contador' => 'Contador',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVistas()
    {
        return $this->hasOne(Vistas::className(), ['id' => 'vistaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasOne(Empresas::className(), ['empresaid' => 'empresaid']);
    }
    
    public static function getVistaAuditaEmpresaByVistaId($vistaid) {
    	
    	$query = self::find()
	    	->where(['empresaid' => Yii::$app->user->identity->empresaid])
	    	->andWhere(['vistaid' => $vistaid])
	    	->one();
    	 
    	if ($query === null) {
    		return null;
    	}
    	return $query;    	
    }
    
    public static function saveVistaAudita($vista) {
    
    	$vista_id = VistasSearch::getVistaByDescripcion($vista);
    	
    	if ($vista_id === null) return;

    	$vista_id = $vista_id->id;
    	
    	$va = self::getVistaAuditaEmpresaByVistaId($vista_id);
    	
    	if ($va === null) {
    		$vista_audita = new VistasAudita();
    	}
    	else {
    		$vista_audita = $va;
    		if ($vista_audita->status === 0) return;
    	}

    	date_default_timezone_set("America/Argentina/Buenos_Aires");
    	
    	$vista_audita->empresaid = Yii::$app->user->identity->empresaid;
    	$vista_audita->vistaid = $vista_id;
    	$vista_audita->ingreso_anterior = ($vista_audita->ultimo_ingreso === null) ? date('Y-m-d H:i:s') : $vista_audita->ultimo_ingreso; 
    	$vista_audita->ultimo_ingreso = date('Y-m-d H:i:s');
    	$vista_audita->status = 1;
    	$vista_audita->contador++;
    	
    	$vista_audita->save();
    	
    }
    
}
