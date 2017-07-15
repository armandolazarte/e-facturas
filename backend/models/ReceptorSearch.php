<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReceptorSearch extends Model
{
    public $cuit;
    public $nombre;
    public $direccion;
    public $localidad;
    public $telefono;

    public function rules()
    {
        return [
            [['cuit', 'cuit'], 'integer'],
            [['nombre', 'nombre'], 'safe'],
            [['direccion', 'direccion'], 'safe'],
            [['localidad', 'localidad'], 'safe'],
            [['telefono', 'telefono'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Receptores::find()->joinWith('empresasreceptores')->where(['empresasreceptores.empresaid'=>Yii::$app->user->identity->empresaid]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 30),
            'sort'=>[
                'attributes'=>[
                        'cuit' => [
                        'asc' => ['cuit' => SORT_ASC],
                        'desc' => ['cuit' => SORT_DESC],
                        'label' => 'cuit',
                    ],
                    'nombre' => [
                        'asc' => ['nombre' => SORT_ASC],
                        'desc' => ['nombre' => SORT_DESC],
                        'label' => 'nombre',
                    ],
                    'direccion' => [
                        'asc' => ['direccion' => SORT_ASC],
                        'desc' => ['direccion' => SORT_DESC],
                        'label' => 'direccion',
                    ],
                    'localidad' => [
                        'asc' => ['localidad' => SORT_ASC],
                        'desc' => ['localidad' => SORT_DESC],
                        'label' => 'localidad',
                    ],
                    'telefono' => [
                        'asc' => ['telefono' => SORT_ASC],
                        'desc' => ['telefono' => SORT_DESC],
                        'label' => 'telefono',
                    ]
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        echo "<br><br><br>";
        echo $this->cuit;
        if ($this->cuit) {
            $query->andWhere(['like', 'cuit', $this->cuit]);
        }
        $query->andWhere(['like', 'nombre', $this->nombre]);
        $query->andWhere(['like', 'direccion', $this->direccion]);
        $query->andWhere(['like', 'localidad', $this->localidad]);
        $query->andWhere(['like', 'telefono', $this->telefono]);

//         print_r($query->all());

        return $dataProvider;
    }
    
    public static function getReceptorById($id)
    {
    	if (($model = Receptores::find()->where(['receptorid'=>$id])->asArray()->one()) !== null) {
    		return $model;
    	} else {
    		return null;
    	}
    }
    
}

 ?>