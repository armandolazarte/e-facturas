<?php

namespace frontend\models;

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
    public $empresa;
    public $nrodde;
    public $nrohta;
    public $impresa;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [        
            ['fchdde', 'date'],
            ['fchhta', 'date'],
            ['puntoventa', 'integer'],
            ['empresa', 'string', 'max' => 255],
            ['nrodde', 'integer'],
            ['nrohta', 'integer'],
            ['impresa', 'integer'],
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
            'empresa' => 'Empresa',
            'nrodde' => 'Numero desde',
            'nrohta' => 'Numero hasta',
            'impresa' => 'Filtrar facturas',
        ];
    }

}
