<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Configfactindex;

/**
 * ConfigfactindexSearch represents the model behind the search form about `backend\models\Configfactindex`.
 */
class ConfigfactindexSearch extends Configfactindex
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'pagesize', 'filtros', 'notificada_color_status', 'impresa_receptor'], 'integer'],
            [['fchdde', 'fchhta', 'orden1_campo', 'orden1_tipo', 'orden2_campo', 'orden2_tipo'], 'safe'],
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
        $query = Configfactindex::find();

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
            'empresaid' => $this->empresaid,
            'pagesize' => $this->pagesize,
            'filtros' => $this->filtros,
            'notificada_color_status' => $this->notificada_color_status,
        ]);

        $query->andFilterWhere(['like', 'fchdde', $this->fchdde])
            ->andFilterWhere(['like', 'fchhta', $this->fchhta])
            ->andFilterWhere(['like', 'orden1_campo', $this->orden1_campo])
            ->andFilterWhere(['like', 'orden1_tipo', $this->orden1_tipo])
            ->andFilterWhere(['like', 'orden2_campo', $this->orden2_campo])
            ->andFilterWhere(['like', 'orden2_tipo', $this->orden2_tipo]);

        return $dataProvider;
    }
}
