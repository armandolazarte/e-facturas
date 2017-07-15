<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Email;


/**
 * This is the model class for table "receptoresemails".
 *
 * @property string $empresaid
 * @property string $receptorid
 * @property string $email
 */
class Receptoresemails extends \yii\db\ActiveRecord
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'receptoresemails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid', 'receptorid', 'email'], 'required'],
            [['empresaid', 'receptorid'], 'integer'],
            [['email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
            'receptorid' => 'Receptorid',
            'email' => 'Email',
        ];
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
    
    // ordena y compara 2 arrays con emails para detectar cambios
    public static function isEmailsArrayEquals($array_1, $array_2)
    {
    	sort($array_1);
    	sort($array_2);
    	
    	if ($array_1 === $array_2)
	    	return true;
    	
		return false;
    	
    }
    
    public static function saveEmailsArray($receptorid, $array_emails)
    {
    	$empresaid = Yii::$app->user->identity->empresaid;

    	
    	// ---------------- se borran todos los mails del $receptorid -----------------------------
    	// DELETE FROM `receptoresemails` WHERE receptorid = $receptorid AND empresaid = $empresaid
    	\Yii::$app->db->createCommand()->delete('receptoresemails', 
    			['receptorid' => $receptorid, 'empresaid' => $empresaid])->execute();
    	// -----------------------------------------------------------------------------------------
    	
    	
    	// se guardan los emails ingresados por el usuario.
    	foreach ($array_emails as $email) {
    		$model = new Receptoresemails();
    		$model->empresaid = $empresaid;
    		$model->receptorid = $receptorid;
    		$model->email = $email;
    		
    		$model->save();
    	}
    	
    }
    
    
    /**
     * Email validation.
     *
     * @param $attribute
     */
    public static function validateEmails($array_emails)
    {
    	foreach ($array_emails as $index => $email) {
    		if (!Email::validate($email)) {
    			return $email;
    		}
    	}
    	return true;
    }
    
    
    public static function removeEmailsRepeat($email_principal, $array_emails)
    {
    	$array = [];
    	
    	// se eliminan los emails duplicados
    	$array_emails = array_unique($array_emails);
    	
    	if (in_array($email_principal, $array_emails) || in_array('', $array_emails)) {
    		
	    	foreach ($array_emails as $email) {
	    		
	    		if ($email !== $email_principal && $email != '') {
	    			
		    		array_push($array, $email);
	    		}
	    	}
    	}
    	
    	else {
    		return $array_emails;
    	}

    	return $array;
    }
    
    
}
