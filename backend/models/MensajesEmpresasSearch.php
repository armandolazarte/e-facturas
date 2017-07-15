<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MensajesEmpresas;
use yii\helpers\ArrayHelper;

/**
 * MensajesEmpresasSearch represents the model behind the search form about `backend\models\MensajesEmpresas`.
 */
class MensajesEmpresasSearch extends MensajesEmpresas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mensajeid', 'empresaid'], 'integer'],
            [['empresa', 'titulo', 'sizetitulo', 'descripcion', 'textalign', 'colorfondo', 'vista', 'vigenciadesde', 'vigenciahasta', 'activo', 'permitecerrar'], 'safe'],
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
        $query = MensajesEmpresas::find();

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
            'mensajeid' => $this->mensajeid,
            'empresaid' => $this->empresaid,
            'vigenciadesde' => $this->vigenciadesde,
            'vigenciahasta' => $this->vigenciahasta,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'sizetitulo', $this->sizetitulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'textalign', $this->textalign])
            ->andFilterWhere(['like', 'colorfondo', $this->colorfondo])
            ->andFilterWhere(['like', 'vista', $this->vista])
            ->andFilterWhere(['like', 'activo', $this->activo])
            ->andFilterWhere(['like', 'permitecerrar', $this->permitecerrar]);

        return $dataProvider;
    }
    
    
    public static function getMensajesArray($VISTA)
    {
    	
    	$HOY = date('Y-m-d');
    	
    	$mensajes = self::find()
    	->where(['like', 'empresaid', Yii::$app->user->identity->empresaid])
        ->orFilterWhere(['OR LIKE', 'empresaid', 'TODAS'])
    	->andWhere(['vista'=>$VISTA])
    	->andWhere('vigenciadesde <= :FECHA',['FECHA'=>$HOY])
    	->andWhere('vigenciahasta >= :FECHA',['FECHA'=>$HOY])
    	->andWhere(['activo'=>'SI'])
    	->asArray()->all();

    
    	if ($mensajes)
    		return $mensajes;
    
    	return [];
    
    }
    
}
