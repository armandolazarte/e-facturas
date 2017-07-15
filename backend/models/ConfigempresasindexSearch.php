<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Configempresasindex;

/**
 * ConfigempresasindexSearch represents the model behind the search form about `backend\models\Configempresasindex`.
 */
class ConfigempresasindexSearch extends Configempresasindex
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid'], 'integer'],
            [['fchdde', 'fchhta'], 'safe'],
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
        $query = Configempresasindex::find();

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
            'fchdde' => $this->fchdde,
            'fchhta' => $this->fchhta,
        ]);

        return $dataProvider;
    }
}
