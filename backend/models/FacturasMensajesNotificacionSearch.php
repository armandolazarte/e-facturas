<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FacturasMensajesNotificacion;

/**
 * FacturasMensajesNotificacionSearch represents the model behind the search form about `backend\models\FacturasMensajesNotificacion`.
 */
class FacturasMensajesNotificacionSearch extends FacturasMensajesNotificacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid', 'mensajeid'], 'integer'],
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
        $query = FacturasMensajesNotificacion::find();

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
            'facturaid' => $this->facturaid,
            'mensajeid' => $this->mensajeid,
        ]);

        return $dataProvider;
    }
}
