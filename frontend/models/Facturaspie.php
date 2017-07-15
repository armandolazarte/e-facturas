<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "facturaspie".
 *
 * @property string $facturapieid
 * @property string $facturaid
 * @property double $importetotal
 * @property double $importenogravado
 * @property double $importegravado
 * @property double $importeiva
 * @property double $importetributos
 * @property double $importeoperacionesexentas
 * @property double $importepercepcionesnacionales
 * @property double $importeiibb
 * @property double $importepercepcionesmunicipales
 * @property double $importeimpuestosinternos
 * @property double $importebonificaciones
 * @property string $formapagoid
 * @property string $fechadesde
 * @property string $fechahasta
 * @property string $fechavencimientopago
 * @property string $codigomonedaid
 * @property double $tipocambio
 * @property string $cae
 * @property string $caefecha
 * @property string $caevencimiento
 * @property string $caeresultado
 * @property string $caemotivo
 * @property string $request
 * @property string $response
 *
 * @property Facturasenc $factura
 * @property Formaspagofe $formapago
 * @property Codigomonedafe $codigomoneda
 */
class Facturaspie extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturaspie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid'], 'required'],
            [['facturaid', 'formapagoid', 'codigomonedaid'], 'integer'],
            [['importetotal', 'importenogravado', 'importegravado', 'importeiva', 'importetributos', 'importeoperacionesexentas', 'importepercepcionesnacionales', 'importeiibb', 'importepercepcionesmunicipales', 'importeimpuestosinternos', 'importebonificaciones', 'tipocambio'], 'number'],
            [['fechadesde', 'fechahasta', 'fechavencimientopago', 'caefecha', 'caevencimiento'], 'safe'],
            [['cae'], 'string', 'max' => 14],
            [['caeresultado'], 'string', 'max' => 1],
            [['caemotivo'], 'string', 'max' => 2],
            [['request', 'response'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facturapieid' => 'Facturapieid',
            'facturaid' => 'Facturaid',
            'importetotal' => 'Importetotal',
            'importenogravado' => 'Importenogravado',
            'importegravado' => 'Importegravado',
            'importeiva' => 'Importeiva',
            'importetributos' => 'Importetributos',
            'importeoperacionesexentas' => 'Importeoperacionesexentas',
            'importepercepcionesnacionales' => 'Importepercepcionesnacionales',
            'importeiibb' => 'Importeiibb',
            'importepercepcionesmunicipales' => 'Importepercepcionesmunicipales',
            'importeimpuestosinternos' => 'Importeimpuestosinternos',
            'importebonificaciones' => 'Importebonificaciones',
            'formapagoid' => 'Formapagoid',
            'fechadesde' => 'Fechadesde',
            'fechahasta' => 'Fechahasta',
            'fechavencimientopago' => 'Fechavencimientopago',
            'codigomonedaid' => 'Codigomonedaid',
            'tipocambio' => 'Tipocambio',
            'cae' => 'Cae',
            'caefecha' => 'Caefecha',
            'caevencimiento' => 'Caevencimiento',
            'caeresultado' => 'Caeresultado',
            'caemotivo' => 'Caemotivo',
            'request' => 'Request',
            'response' => 'Response',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactura()
    {
        return $this->hasOne(Facturasenc::className(), ['facturaid' => 'facturaid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormapago()
    {
        return $this->hasOne(Formaspagofe::className(), ['pagoid' => 'formapagoid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigomoneda()
    {
        return $this->hasOne(Codigomonedafe::className(), ['monedaid' => 'codigomonedaid']);
    }
    public function getImportetotal()
    {
        return $this->importetotal;
    }
}
