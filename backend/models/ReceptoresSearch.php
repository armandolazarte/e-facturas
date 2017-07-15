<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Receptores;

/**
 * ReceptoresSearch represents the model behind the search form about `backend\models\Receptores`.
 */
class ReceptoresSearch extends Receptores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receptorid', 'documentoid', 'provinciaid', 'responsableid'], 'integer'],
            [['cuit', 'nombre', 'direccion', 'localidad', 'telefono', 'mail'], 'safe'],
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
        $query = Receptores::find()
        ->joinWith('empresasreceptores')
        ->where(['empresasreceptores.empresaid'=>Yii::$app->user->identity->empresaid]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 30),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'receptorid' => $this->receptorid,
            'documentoid' => $this->documentoid,
            'provinciaid' => $this->provinciaid,
            'responsableid' => $this->responsableid,
        ]);

        $query->andFilterWhere(['like', 'cuit', $this->cuit])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'localidad', $this->localidad])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'mail', $this->mail]);

        return $dataProvider;
    }
}
