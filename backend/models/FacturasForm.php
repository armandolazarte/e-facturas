<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FacturasForm extends Model
{
    public $fchdde;
    public $fchhta;
    public $puntoventa;
    public $comprobante;
    public $receptor;
    public $nrodde;
    public $nrohta;
    public $notificada;
    public $impresa;
    public $impresacli;


    public function init(){
        $this->comprobante = 0;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [        
            ['fchdde', 'date'],
            ['fchhta', 'date'],
            ['puntoventa', 'integer'],
            ['comprobante', 'integer'],
            ['receptor', 'string', 'max' => 255],
            ['nrodde', 'integer'],
            ['nrohta', 'integer'],
            ['notificada', 'integer'],
            ['impresa', 'integer'],
            ['impresacli', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fchdde' => 'Fecha desde',
            'fchhta' => 'Fecha hasta',
            'puntoventa' => 'Punto venta',
            'comprobante' => 'Comprobante',
            'receptor' => 'Cliente',
            'nrodde' => 'Numero desde',
            'nrohta' => 'Numero hasta',
            'notificada' => 'Notificada',
            'impresa' => 'Filtrar facturas',
            'impresacli' => 'Impresas por el cliente',
        ];
    }

}
