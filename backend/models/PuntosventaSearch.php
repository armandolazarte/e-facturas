<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Puntosventa;
use yii\helpers\ArrayHelper;


/**
 * PuntosventaSearch represents the model behind the search form about `backend\models\Puntosventa`.
 */
class PuntosventaSearch extends Puntosventa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puntoventaid', 'empresaid'], 'integer'],
            [['puntoventa', 'descripcion', 'fecha'], 'safe'],
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
        $query = Puntosventa::find()
        ->where(['empresaid'=>Yii::$app->user->identity->empresaid])
        ->orderBy(['puntoventa' => SORT_ASC]);
        
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
            'puntoventaid' => $this->puntoventaid,
            'empresaid' => $this->empresaid,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'puntoventa', $this->puntoventa])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    
    public static function getPuntoVentaEmpresaById($id)
    {
    	$puntoventa = Puntosventa::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['puntoventaid'=>$id])->one();
    
    	return $puntoventa;
    
    }    

    public static function getArrayPuntosVentaEmpresa()
    {
    	$query = Puntosventa::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->orderBy(['puntoventa' => SORT_ASC])
    	->asArray()
    	->all();
    
    	return ArrayHelper::map($query, 'puntoventaid', 'puntoventa');
    
    }    
    
    
    public static function getPuntosVentaIdEmpresaLimit1()
    {
    	$query = Puntosventa::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->orderBy(['puntoventa' => SORT_ASC])
    	->limit(1)
    	->asArray()
    	->all();
    
    	if (count($query) > 0)
	    	return $query[0];
    	 
    	return null;
    	
    
    }
    
    public static function isPuntoVentaEmpresaExist($puntoventa)
    {
    	$pv = Puntosventa::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['puntoventa'=>$puntoventa])->one();
    
    	if ($pv)
    		return true;
    	 
    	return false;
    
    }

    public static function isPuntoVentaExist()
    {
    	$pv = Puntosventa::find()->where(['empresaid'=>Yii::$app->user->identity->empresaid])->one();
    
    	if ($pv)
    		return true;
    
    	return false;
    
    }
    
    public static function getArrayMailsByReceptorId($id)
    {
    	$query = self::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['receptorid'=>$id])
    	->asArray()
    	->all();
    
    	$query_array = ArrayHelper::map($query, 'email', 'email');
    	 
    	$array = [];
    	 
    	foreach ($query_array as $email) {
    		array_push($array, $email);
    	}
    	 
    	sort($array);
    	 
    	return $array;
    }
    
}
