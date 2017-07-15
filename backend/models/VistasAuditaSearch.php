<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VistasAudita;

/**
 * VistasAuditaSearch represents the model behind the search form about `backend\models\VistasAudita`.
 */
class VistasAuditaSearch extends VistasAudita
{
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['empresaid', 'vistaid', 'status', 'ultimo_ingreso', 'ingreso_anterior', 'contador'], 'safe'],
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
    	
        $query = VistasAudita::find()
        ->joinWith('empresas')
        ->joinWith('vistas');

        // si no se aplican parametros de ordenamiento
        // se orden por empresa y ultimo_ingreso
        if (count($params) == 1) {
	        $query->orderBy(['empresas.razonsocial' => SORT_ASC, 'ultimo_ingreso' => SORT_DESC]);
	    	// 		SORT_DESC = 3   ---   SORT_ASC = 4
        }
        

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

        $query->andFilterWhere(['like', 'empresas.razonsocial', $this->empresaid])
        ->andFilterWhere(['like', 'ultimo_ingreso', $this->ultimo_ingreso])
        ->andFilterWhere(['like', 'ingreso_anterior', $this->ingreso_anterior])
        ->andFilterWhere(['like', 'vistas.descripcion', $this->vistaid])
        ->andFilterWhere(['like', 'status', $this->status])
        ->andFilterWhere(['like', 'contador', $this->contador])
        ;
        
        
        return $dataProvider;
    }
}
