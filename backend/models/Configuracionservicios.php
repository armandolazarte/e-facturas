<?php

namespace backend\models;

use Yii;
use backend\models\Servicios;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "configuracionservicios".
 *
 * @property string $configid
 * @property string $empresaid
 * @property integer $servicioid
 * @property string $fecha
 * @property string $carpeta
 * @property string $carpetacae
 * @property string $carpetaerror
 * @property integer $produccion
 *
 * @property Empresas $empresa
 * @property Servicios $servicio
 */
class Configuracionservicios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuracionservicios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['servicioid'], 'required','message' => 'El servicio es un campo requerido.'],
            [['empresaid', 'servicioid', 'produccion'], 'integer'],
            [['fecha'], 'safe'],
            [['carpeta', 'carpetacae', 'carpetaerror'], 'string', 'max' => 8000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'configid' => 'Configid',
            'empresaid' => 'Empresaid',
            'servicioid' => 'Servicio',
            'fecha' => 'Fecha',
            'carpeta' => 'Carpeta',
            'carpetacae' => 'Carpeta cae',
            'carpetaerror' => 'Carpeta error',
            'produccion' => 'Produccion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['empresaid' => 'empresaid']);
    }

    
    public function getServiciosArray()
    {
    	$opciones = Servicios::find()->asArray()->all();
    	return ArrayHelper::map($opciones, 'servicioid', 'descripcion');
    }
}
