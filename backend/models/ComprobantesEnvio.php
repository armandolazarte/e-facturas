<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comprobantesenvio".
 *
 * @property string $comprobanteenvioid
 * @property string $empresaid
 * @property string $puntoventaid
 * @property string $comprobanteid
 * @property integer $comprobantenro
 * @property string $fechaenvio
 * @property string $observaciones
 * @property string $errores
 * @property string $fecha_rechazo
 * @property integer $estadoid
 */
class ComprobantesEnvio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comprobantesenvio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid'], 'required'],
            [['empresaid', 'puntoventaid', 'comprobanteid', 'comprobantenro', 'estadoid'], 'integer'],
            [['fechaenvio', 'fecha_rechazo', 'comprobanteenvioid'], 'safe'],
            [['observaciones', 'errores'], 'string', 'max' => 8000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comprobanteenvioid' => 'Comprobanteenvioid',
            'empresaid' => 'Empresaid',
            'puntoventaid' => 'Puntoventaid',
            'comprobanteid' => 'Comprobanteid',
            'comprobantenro' => 'Comprobantenro',
            'fechaenvio' => 'Fechaenvio',
            'observaciones' => 'Observaciones',
            'errores' => 'Errores',
            'fecha_rechazo' => 'Fecha Rechazo',
            'estadoid' => 'Estadoid',
        ];
    }
}
