<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "facturas_debugger".
 *
 * @property string $facturaid
 * @property double $height_barcode
 * @property double $width_barcode
 * @property integer $font_barcode
 * @property integer $status
 */
class FacturasDebugger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturas_debugger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facturaid', 'height_barcode', 'width_barcode', 'font_barcode', 'status'], 'required'],
            [['facturaid', 'font_barcode', 'status'], 'integer'],
            [['height_barcode', 'width_barcode'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facturaid' => 'Facturaid',
            'height_barcode' => 'Height Barcode',
            'width_barcode' => 'Width Barcode',
            'font_barcode' => 'Font Barcode',
            'status' => 'Status',
        ];
    }
}
