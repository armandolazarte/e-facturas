<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EmpresasEmailSender;

/**
 * EmpresasEmailSenderSearch represents the model behind the search form about `backend\models\EmpresasEmailSender`.
 */
class EmpresasEmailSenderSearch extends EmpresasEmailSender
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'status'], 'integer'],
            [['nombre', 'email', 'password', 'hash_validate'], 'safe'],
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
        $query = EmpresasEmailSender::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'hash_validate', $this->hash_validate]);

        return $dataProvider;
    }
}
