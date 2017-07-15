<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use backend\models\Mails;

/**
 * MailsSearch represents the model behind the search form about `backend\models\Mails`.
 */
class MailsSearch extends Mails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mailid', 'empresaid'], 'integer'],
            [['nombre', 'mail'], 'safe'],
        ];
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
        $query = Mails::find()->where(['empresaid'=>Yii::$app->user->identity->empresaid]);

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
            'mailid' => $this->mailid,
            'empresaid' => $this->empresaid,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'mail', $this->mail]);

        return $dataProvider;
    }

    
    public static function getMailEmpresaById($id)
    {
    	$mail = Mails::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['mailid'=>$id])->one();
    
    	return $mail;
    
    }
    
    
    public static function isMailEmpresaExist($mail)
    {
    	$mail = Mails::find()
    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
    	->andWhere(['mail'=>$mail])->one();
    
    	if ($mail)
    		return true;
    	
    	return false;
    
    }

    public static function getMailsByEmpresa($EMPRESA_ID)
    {
    	$mail = Mails::find()->where(['empresaid'=>$EMPRESA_ID])->all();
    
    	if ($mail)
    		return true;
    	
    	return false;
    	
    
    }

    public static function getSingleArrayMailsByEmpresa($EMPRESA_ID)
    {
    	$array_emails = Mails::find()->where(['empresaid'=>$EMPRESA_ID])->asArray()->all();
    	$array_emails = ArrayHelper::map($array_emails, 'mail', 'mail');
    
    	if ($array_emails !== null) {

    		$array = [];

    		foreach ($array_emails as $email) {
				array_push($array, $email);
    		}
    		
    		return $array;
    	}
    	 
    	return null;
    	 
    
    }
    
    
}
