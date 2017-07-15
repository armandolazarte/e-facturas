<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FacturasDebugger;

/**
 * FacturasDebuggerSearch represents the model behind the search form about `backend\models\FacturasDebugger`.
 */
class FacturasDebuggerSearch extends FacturasDebugger
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid', 'font_barcode', 'status'], 'integer'],
            [['height_barcode', 'width_barcode'], 'number'],
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
        $query = FacturasDebugger::find();

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
            'height_barcode' => $this->height_barcode,
            'width_barcode' => $this->width_barcode,
            'font_barcode' => $this->font_barcode,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
