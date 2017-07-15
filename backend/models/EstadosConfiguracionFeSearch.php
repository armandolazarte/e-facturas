<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EstadosConfiguracionFe;

/**
 * EstadosConfiguracionFeSearch represents the model behind the search form about `backend\models\EstadosConfiguracionFe`.
 */
class EstadosConfiguracionFeSearch extends EstadosConfiguracionFe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activo'], 'integer'],
            [['titulo', 'descripcion', 'vista', 'estado'], 'safe'],
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
        $query = EstadosConfiguracionFe::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'vista', $this->vista])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
