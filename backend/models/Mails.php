<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mails".
 *
 * @property integer $mailid
 * @property string $empresaid
 * @property string $nombre
 * @property string $mail
 */
class Mails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['nombre', 'mail'], 'filter', 'filter' => 'trim'],
			[['mail'], 'filter', 'filter' => 'strtolower'],
//         	[['mail'], 'unique', 'on' => 'create'],
       		[['mail'], 'required','message' => 'El email es un campo requerido.'],
        	[['nombre'], 'required','message' => 'El nombre es un campo requerido.'],
       		[['mail'], 'email', 'message' => 'El formato del email no es correcto.'],
            [['nombre'], 'string', 'max' => 30],
        	[['mail'], 'string', 'max' => 70]
        ];
    }
    


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mailid' => 'Mailid',
            'empresaid' => 'Empresaid',
            'nombre' => 'Nombre',
            'mail' => 'Email',
        ];
    }
    
    
}
