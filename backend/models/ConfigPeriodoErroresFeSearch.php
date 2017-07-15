<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ConfigPeriodoErroresFe;

/**
 * ConfigPeriodoErroresFeSearch represents the model behind the search form about `backend\models\ConfigPeriodoErroresFe`.
 */
class ConfigPeriodoErroresFeSearch extends ConfigPeriodoErroresFe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid'], 'integer'],
            [['periodo'], 'safe'],
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
        $query = ConfigPeriodoErroresFe::find();

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
        ]);

        $query->andFilterWhere(['like', 'periodo', $this->periodo]);

        return $dataProvider;
    }
}
