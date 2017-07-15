<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ComprobantesEnvio;
use yii\db\Query;
use backend\models\ConfigPeriodoErroresFe;

/**
 * ComprobantesEnvioSearch represents the model behind the search form about `backend\models\ComprobantesEnvio`.
 */
class ComprobantesEnvioSearch extends ComprobantesEnvio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//             [['comprobanteenvioid', 'empresaid', 'puntoventaid', 'comprobanteid', 'comprobantenro', 'estadoid'], 'integer'],
            [['fechaenvio', 'observaciones', 'errores', 'fecha_rechazo', 'comprobanteenvioid', 'empresaid', 'puntoventaid', 'comprobanteid', 'comprobantenro', 'estadoid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

    	// $empresaid = 0; el cero es para ver el periodo del ADMIN
    	$empresaid = 0;
    	$periodo = ConfigPeriodoErroresFe::getPeriodoEmpresa($empresaid);
    	$periodo_desde = ConfigPeriodoErroresFe::getFechaDesdePeriodoFeError($periodo);
    	$periodo_hasta = date('Ymd', strtotime(date('Ymd') . ' +1000 day'));
    	 
		$query = new Query;
		$query
			->select('
					`comprobanteenvioid`,
					`razonsocial` as "empresaid",
    				`puntosventa`.`puntoventa` as "puntoventaid",
    				`tipocomprobantefe`.`descripcion` as "comprobanteid", 
    				`comprobantenro`,
    				`fechaenvio`,
    				`observaciones`,
    				`errores`,
    				`fecha_rechazo`,
    				(
							SELECT max(e.facturaid) FROM `facturasenc` e 
							inner join facturaspie p on e.facturaid = p.facturaid
							where `empresaid` = `comprobantesenvio`.`empresaid` and 
							`puntoventa` = `comprobantesenvio`.`puntoventaid` and
							`comprobanteid` = `comprobantesenvio`.`comprobanteid` and
							`comprobantenro` = `comprobantesenvio`.`comprobantenro` and
							`caeresultado` = "" and
							`cae` = 0
					) as `estadoid`
    			')
			->from('comprobantesenvio')
    		->join('INNER JOIN', 'empresas', 'comprobantesenvio.empresaid = empresas.empresaid')
    		->join('INNER JOIN', 'puntosventa', 'comprobantesenvio.puntoventaid = puntosventa.puntoventaid')
    		->join('INNER JOIN', 'tipocomprobantefe', 'comprobantesenvio.comprobanteid = tipocomprobantefe.comprobanteid')
			->where(
					'fecha_rechazo between ' . $periodo_desde . ' and ' . $periodo_hasta .
					' AND `estadoid`=3 
					AND NOT `errores` IS NULL 
					AND NOT `observaciones` IS NULL 
					AND NOT `fecha_rechazo` IS NULL
				')
        	->orderBy(['fecha_rechazo'=> SORT_DESC]);
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                            'pagesize' => -1,
                    ],
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
//             'comprobanteenvioid' => $this->comprobanteenvioid,
//             'empresaid' => $this->empresaid,
//             'puntoventaid' => $this->puntoventaid,
//             'comprobanteid' => $this->comprobanteid,
//             'comprobantenro' => $this->comprobantenro,
            'fechaenvio' => $this->fechaenvio,
            'fecha_rechazo' => $this->fecha_rechazo,
//             'estadoid' => $this->estadoid,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'errores', $this->errores])
            ->andFilterWhere(['like', 'comprobantenro', $this->comprobantenro])
            ->andFilterWhere(['like', 'puntosventa.puntoventa', $this->puntoventaid])
            ->andFilterWhere(['like', 'tipocomprobantefe.descripcion', $this->comprobanteid])
            ->andFilterWhere(['like', 'empresas.razonsocial', $this->empresaid])
        ;

        return $dataProvider;
    }

    
    public static function getCountErroresFeEmpresa()
    {
    	$empresaid = Yii::$app->user->identity->empresaid;
    	$periodo = ConfigPeriodoErroresFe::getPeriodoEmpresa($empresaid);
    	$periodo_desde = ConfigPeriodoErroresFe::getFechaDesdePeriodoFeError($periodo);
    	$periodo_hasta = date('Ymd', strtotime(date('Ymd') . ' +1000 day'));
    
    	$query = new Query;
    	$query
    	->select('count(*) as errores')
                    ->from('comprobantesenvio')
                    ->where('
                      comprobantesenvio.empresaid = ' . $empresaid .
					' AND fecha_rechazo between ' . $periodo_desde . ' and ' . $periodo_hasta .
                    ' AND `estadoid`= 3
                      AND NOT `errores` IS NULL
                      AND NOT `observaciones` IS NULL
                      AND NOT `fecha_rechazo` IS NULL
                ');
    
    	$query = $query->all();
    	
    	if ($query !== null) {
    		return $query[0]['errores'];
    	}
    	else {
	    	return 0;
    	}
    }
    

    public static function getQueryErroresEmpresa()
    {
        $empresaid = Yii::$app->user->identity->empresaid;
        $periodo = ConfigPeriodoErroresFe::getPeriodoEmpresa($empresaid);
        $periodo_desde = ConfigPeriodoErroresFe::getFechaDesdePeriodoFeError($periodo);
        $periodo_hasta = date('Ymd', strtotime(date('Ymd') . ' +1000 day'));
        
        $query = new Query;
        $query
        ->select('
                    `puntosventa`.`puntoventa` as "puntoventaid",
                    `tipocomprobantefe`.`descripcion` as "comprobanteid",
                    `comprobantenro`,
                    `fechaenvio`,
                    `observaciones`,
                    `errores`,
                    `fecha_rechazo`,
					(
							SELECT max(e.facturaid) FROM `facturasenc` e 
							inner join facturaspie p on e.facturaid = p.facturaid
							where `empresaid` = `comprobantesenvio`.`empresaid` and 
							`puntoventa` = `comprobantesenvio`.`puntoventaid` and
							`comprobanteid` = `comprobantesenvio`.`comprobanteid` and
							`comprobantenro` = `comprobantesenvio`.`comprobantenro` and
							`caeresultado` = "" and
							`cae` = 0
					) as `estadoid`
                ')
                    ->from('comprobantesenvio')
                    ->join('INNER JOIN', 'puntosventa', 'comprobantesenvio.puntoventaid = puntosventa.puntoventaid')
                    ->join('INNER JOIN', 'tipocomprobantefe', 'comprobantesenvio.comprobanteid = tipocomprobantefe.comprobanteid')
                    ->where('
                    comprobantesenvio.empresaid = ' . $empresaid . 
                    ' AND fecha_rechazo between ' . $periodo_desde . ' and ' . $periodo_hasta . 
                    ' AND `estadoid`=3
                    AND NOT `errores` IS NULL
                    AND NOT `observaciones` IS NULL
                    AND NOT `fecha_rechazo` IS NULL
                ')
                    ->orderBy(['fecha_rechazo'=> SORT_DESC]);
    
        
        return $query;
    }
    
    public static function getFacturaIdAnteriorConCae($model)
    {

    	$query = new Query;
    	$query
    	->select('max(facturasenc.facturaid) as id')
                    ->from('facturasenc')
                    ->join('INNER JOIN', 'facturaspie', 'facturasenc.facturaid = facturaspie.facturaid')
                    ->where('
                    		  empresaid = ' . $model['empresaid'] .
							' and puntoventa = ' . $model['puntoventa'] . 
							' and comprobanteid = ' . $model['comprobanteid'] . 
							' and comprobantenro < ' . $model['comprobantenro'] .
							' and caeresultado = "A"
							  and cae > 0
                ');

    	

        $query = $query->all();

        if ($query[0]['id'] === null) {
            $query[0]['id'] = '-1';
            
        }


        return $query[0];
    }
    

    public static function getFacturasPieByFacturaId($facturaid)
    {
    	$query = new Query;
    	$query
    	->select('*')
    	->from('facturaspie')
    	->where('facturaid = ' . $facturaid);
    
        $query = $query->all();


        if (count($query) > 0) {
            return $query[0];
        }
        else {
            return null;
        }        
    }    
    
    public function getErroresEmpresa($params)
    {
    	
    	$query = self::getQueryErroresEmpresa();
    
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    			'pagination' => [
    					'pagesize' => -1,
    			],
    	]);
    
    	$this->load($params);
    
    	if (!$this->validate()) {
    		// uncomment the following line if you do not want to any records when validation fails
    		// $query->where('0=1');
    		return $dataProvider;
    	}
    
    	$query->andFilterWhere([
    	//             'comprobanteenvioid' => $this->comprobanteenvioid,
    	//             'empresaid' => $this->empresaid,
    	//             'puntoventaid' => $this->puntoventaid,
    	//             'comprobanteid' => $this->comprobanteid,
    	//             'comprobantenro' => $this->comprobantenro,
//     			'fechaenvio' => $this->fechaenvio,
//     			'fecha_rechazo' => $this->fecha_rechazo,
    			//             'estadoid' => $this->estadoid,
    	]);
    
    	$query->andFilterWhere(['like', 'observaciones', $this->observaciones])
    	->andFilterWhere(['like', 'errores', $this->errores])
    	->andFilterWhere(['like', 'fecha_rechazo', $this->fecha_rechazo])
    	->andFilterWhere(['like', 'comprobantenro', $this->comprobantenro])
    	->andFilterWhere(['like', 'puntosventa.puntoventa', $this->puntoventaid])
    	->andFilterWhere(['like', 'tipocomprobantefe.descripcion', $this->comprobanteid])
    	;
    
    	return $dataProvider;
    }
    
    
    
    
    
}
