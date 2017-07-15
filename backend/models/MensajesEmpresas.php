<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mensajes_empresas".
 *
 * @property integer $mensajeid
 * @property string $empresaid
 * @property string $empresa
 * @property string $titulo
 * @property string $sizetitulo
 * @property string $descripcion
 * @property string $textalign
 * @property string $colorfondo
 * @property string $vista
 * @property string $vigenciadesde
 * @property string $vigenciahasta
 * @property string $activo
 * @property string $permitecerrar
 */
class MensajesEmpresas extends \yii\db\ActiveRecord
{
		
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensajes_empresas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'vista', 'vigenciadesde', 'vigenciahasta'], 'required'],
            [['empresaid'], 'string'],
            [['sizetitulo', 'descripcion', 'textalign', 'colorfondo', 'activo', 'permitecerrar'], 'string'],
            [['vigenciadesde', 'vigenciahasta', 'empresaid'], 'safe'],
            [['empresa'], 'string', 'max' => 255],
			[['empresaid'], 'string', 'max' => 1024],
            [['titulo'], 'string', 'max' => 50],
            [['vista'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mensajeid' => 'Mensajeid',
            'empresaid' => 'Empresaid',
            'empresa' => 'Empresa',
            'titulo' => 'Titulo',
            'sizetitulo' => 'Size Titulo',
            'descripcion' => 'Descripcion',
            'textalign' => 'Text Align',
            'colorfondo' => 'Color Fondo',
            'vista' => 'Vista',
            'vigenciadesde' => 'Desde',
            'vigenciahasta' => 'Hasta',
            'activo' => 'Activo',
            'permitecerrar' => 'Permite Cerrar Mensaje',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function setValuesDefault()
    {
    	$this->vista = 'site/index';
    	$this->activo = 1;
    	$this->permitecerrar = 0;
    
    	$this->vigenciadesde = date('d/m/Y');
    	$prox_anio = mktime(0, 0, 0, date("m") + 1 , date("d"), date("Y"));
    	$this->vigenciahasta = date('d/m/Y', $prox_anio);
    
    }
    
}
