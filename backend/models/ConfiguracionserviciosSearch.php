<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Configuracionservicios;

/**
 * ConfiguracionserviciosSearch represents the model behind the search form about `backend\models\Configuracionservicios`.
 */
class ConfiguracionserviciosSearch extends Configuracionservicios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['configid', 'empresaid', 'servicioid', 'produccion'], 'integer'],
            [['fecha', 'carpeta', 'carpetacae', 'carpetaerror'], 'safe'],
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
        $query = Configuracionservicios::find()->where(['empresaid'=>Yii::$app->user->identity->empresaid]);

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
            'configid' => $this->configid,
            'empresaid' => $this->empresaid,
            'servicioid' => $this->servicioid,
            'fecha' => $this->fecha,
            'produccion' => $this->produccion,
        ]);

        $query->andFilterWhere(['like', 'carpeta', $this->carpeta])
            ->andFilterWhere(['like', 'carpetacae', $this->carpetacae])
            ->andFilterWhere(['like', 'carpetaerror', $this->carpetaerror]);

        return $dataProvider;
    }


    public static function getConfigServiciosEmpresaById($id)
    {
    	$config = Configuracionservicios::find()
    				->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    				->andWhere(['configid'=>$id])->one();
    
    	return $config;
    
    }
    
    /*
     * devuelve la configuracion por default del servicio
     * en este caso lo obtiene de la tabla configuracionservicios
     * con configid y empresaid ambos = -1
     */
    public static function getConfigServiciosEmpresaDefault()
    {
    	$default = -1;
    	$config = Configuracionservicios::find()->where(['empresaid'=>$default])->andWhere(['configid'=>$default])->one();
    
    	if (!$config) {
	    	$config = new Configuracionservicios();
	    	$config->servicioid = 1;
	    	$config->carpeta = 'C:\H2O\FE';
	    	$config->carpetacae = 'C:\H2O\FERESUL';
	    	$config->carpetaerror = 'C:\H2O\FEERROR';
	    	$config->produccion = 1;
    	}
    	
    	return $config;
    }
    
    
    public static function isConfigServiciosEmpresaExist()
    {
    	$config = Configuracionservicios::find()
    				->where(['empresaid'=>Yii::$app->user->identity->empresaid])->one();
    
    	return $config;
    
    }
    


}
