<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "configempresasindex".
 *
 * @property string $empresaid
 * @property string $fchdde
 * @property string $fchhta
 */
class Configempresasindex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configempresasindex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fchdde', 'fchhta'], 'required'],
            [['empresaid'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empresaid' => 'Empresaid',
            'fchdde' => 'Fchdde',
            'fchhta' => 'Fchhta',
        ];
    }
}
