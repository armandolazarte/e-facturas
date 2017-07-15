<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "configfacturasindex".
 *
 * @property integer $empresaid
 * @property integer $fchdde
 * @property integer $fchhta
 * @property integer $pagesize
 * @property integer $filtros
 * @property integer $notificada_color_status
 * @property string $orden1_campo
 * @property string $orden1_tipo
 * @property string $orden2_campo
 * @property string $orden2_tipo
 * @property integer $mostrar_impresas
 */
class Configfactindex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configfacturasindex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresaid'], 'required'],
            [['empresaid', 'fchdde', 'fchhta', 'pagesize', 'filtros', 'notificada_color_status', 'mostrar_impresas'], 'integer'],
            [['orden1_campo', 'orden1_tipo', 'orden2_campo', 'orden2_tipo'], 'string', 'max' => 20]
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
            'pagesize' => 'Paginacion',
            'filtros' => 'Filtrar Busqueda',
            'notificada_color_status' => 'Notificada Color Status',
            'orden1_campo' => 'Orden 1 Campo',
            'orden1_tipo' => 'Orden 1 Tipo',
            'orden2_campo' => 'Orden 2 Campo',
            'orden2_tipo' => 'Orden 2 Tipo',
            'mostrar_impresas' => 'Mostrar Impresas',
        ];
    }

    public static function createDefault()
    {
        $model = new Configfactindex();
        $model->empresaid = Yii::$app->user->identity->empresaid;
        $model->mostrar_impresas = 1;
        $model->save();
    }

}
