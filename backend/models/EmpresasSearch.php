<?php

namespace backend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Empresas;

/**
 * EmpresasSearch represents the model behind the search form about `backend\models\Empresas`.
 */
class EmpresasSearch extends Empresas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'prestadorid', 'responsableid', 'provinciaid', 'cuponpf', 'cuitasociado'], 'integer'],
            [['nrocuit', 'razonsocial', 'nroiibb', 'inicioact', 'calle', 'nro', 'piso', 'depto', 'cp', 'manzana', 'localidad', 'sector', 'torre', 'telefono', 'url', 'gln', 'fechabaja', 'email'], 'safe'],
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

    	// SUBCONSULTAS
    	
    	$fechas = Configempresasindex::findOne(Yii::$app->user->identity->empresaid);
    	
     	$where_fechas_between = "e.fechafactura between '$fechas->fchdde' and '$fechas->fchhta'"; 
    	
    	$inner_join_fe_fp = "facturasenc e inner join facturaspie p on e.facturaid = p.facturaid";
    	$where_condicion = "cae > 0 and e.empresaid = empresas.empresaid and $where_fechas_between"; 
    	
        $count_fe = "(SELECT count(DISTINCT(cae)) FROM $inner_join_fe_fp where $where_condicion)"; // as cuitasociado
        $max_caefecha = "(SELECT max(caefecha) FROM $inner_join_fe_fp where $where_condicion)"; // as fechabaja
        $min_caefecha = "(SELECT min(caefecha) FROM $inner_join_fe_fp where $where_condicion)"; // as url
        $max_fchnotif = "(SELECT max(caefecha) FROM $inner_join_fe_fp where $where_condicion and notificada = 1)"; // as telefono        

        $query = Empresas::find()
        	->select("empresaid, razonsocial, nrocuit, inicioact, nroiibb, $count_fe as cuitasociado, $max_caefecha as fechabaja"
			)->where('empresaid > 0 and not nrocuit is null');
        
        
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
            'empresaid' => $this->empresaid,
            'inicioact' => $this->inicioact,
//             'prestadorid' => $this->prestadorid,
//             'responsableid' => $this->responsableid,
//             'provinciaid' => $this->provinciaid,
//             'cuponpf' => $this->cuponpf,
//             'fechabaja' => $this->fechabaja,
//             'cuitasociado' => $this->cuitasociado,
        ]);

        $query->andFilterWhere(['like', 'nrocuit', $this->nrocuit])
            ->andFilterWhere(['like', 'razonsocial', $this->razonsocial])
            ->andFilterWhere(['like', 'nroiibb', $this->nroiibb]);
//             ->andFilterWhere(['like', 'calle', $this->calle])
//             ->andFilterWhere(['like', 'nro', $this->nro])
//             ->andFilterWhere(['like', 'piso', $this->piso])
//             ->andFilterWhere(['like', 'depto', $this->depto])
//             ->andFilterWhere(['like', 'cp', $this->cp])
//             ->andFilterWhere(['like', 'manzana', $this->manzana])
//             ->andFilterWhere(['like', 'localidad', $this->localidad])
//             ->andFilterWhere(['like', 'sector', $this->sector])
//             ->andFilterWhere(['like', 'torre', $this->torre])
//             ->andFilterWhere(['like', 'telefono', $this->telefono])
//             ->andFilterWhere(['like', 'url', $this->url])
//             ->andFilterWhere(['like', 'gln', $this->gln])
//             ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
    
    public static function getComprobantesByEmpresaId($empid)
    {
    	if (!is_numeric($empid)) {
    		return null;
    	}
    	
    	$fechas = Configempresasindex::findOne(Yii::$app->user->identity->empresaid);
    	
     	$where_fechas_between = "facturasenc.fechafactura between '$fechas->fchdde' and '$fechas->fchhta'"; 
    	
    	$query = Yii::$app->db->createCommand('
				SELECT `puntosventa`.`puntoventa` AS `Punto_Venta`, `tipocomprobantefe`.`descripcion` AS `Comprobante`, 
    			count(DISTINCT(cae)) as Cantidad, notificada as Notificada
				FROM `facturasenc` 
				INNER JOIN `facturaspie` ON facturasenc.facturaid = facturaspie.facturaid 
				INNER JOIN `tipocomprobantefe` ON facturasenc.comprobanteid = tipocomprobantefe.comprobanteid 
				INNER JOIN `puntosventa` ON facturasenc.puntoventa = puntosventa.puntoventaid 
				WHERE facturaspie.cae > 0 and facturasenc.empresaid = '. $empid .' and '. $where_fechas_between. '
				GROUP BY `puntosventa`.`puntoventa`, `tipocomprobantefe`.`descripcion`, notificada WITH ROLLUP    			
    			')->queryAll();
    	 
    	if ($query){
    		return $query;
    	}
    	else {
    		return null;
    	}    	
    	
    	
// 		$query = new Query;
// 		$query
// 			->select('puntosventa.puntoventa as Punto_Venta, tipocomprobantefe.descripcion as Comprobante, count(DISTINCT(cae)) as Cantidad, notificada as Notificada')  
// 			->from('facturasenc')
// 			->join('INNER JOIN', 'facturaspie', 'facturasenc.facturaid = facturaspie.facturaid')
// 			->join('INNER JOIN', 'tipocomprobantefe', 'facturasenc.comprobanteid = tipocomprobantefe.comprobanteid')
// 			->join('INNER JOIN', 'puntosventa', 'facturasenc.puntoventa = puntosventa.puntoventaid')
// 			->where('facturaspie.cae > 0 and facturasenc.empresaid = ' . $empid)		
// 			->groupBy('puntosventa.puntoventa, tipocomprobantefe.descripcion, notificada')
// 			;
// 		$command = $query->createCommand();
// 		$data = $command->queryAll();		
//     	return $data;
    	
    	
    }


    // devuelve las fechas desde-hasta para buscar las facturas en search($params) (index empresas)
    public static function getFechasConfigEmpresasIndex()
    {
    	$query = Yii::$app->db->createCommand('SELECT * FROM configempresasindex')->queryAll();
    
    	if ($query){
    		return $query;
    	}
    	else {
    		return null;
    	}
    
    }


}
