<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Empresauseradmin;

/**
 * EmpresauseradminSearch represents the model behind the search form about `backend\models\Empresauseradmin`.
 */
class EmpresauseradminSearch extends Empresauseradmin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['empresaid','username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
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
        $query = Empresauseradmin::find();

        $query->joinWith('empresas');
        
        $query->orderBy(['empresas.empresaid' => SORT_ASC]);
        
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
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
//             'empresaid' => $this->empresaid,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'empresauser.email', $this->email]);
        
        $query->andFilterWhere(['like', 'empresas.razonsocial', $this->empresaid]);

        return $dataProvider;
    }
}
