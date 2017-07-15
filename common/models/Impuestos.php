<?php
namespace common\models;

use Yii;

class Impuestos
{

    public static function getImporte($array_tributo, $impuesto, $pos)
    {

        $impuesto = strtoupper($impuesto);
        $importe = '';

        if ( count($array_tributo) == 0 ) {
            $importe = '';
        }

        else if ( count($array_tributo) == 1 ) {
            if (strtoupper($array_tributo[0]->descripcion) == $impuesto) {
                $importe = ''.$array_tributo[0]->importe;  
            }

                if (strtoupper($array_tributo[0]->descripcion) == 'IMPUESTOS PROVINCIALES' && $impuesto == 'IIBB') {
                    $importe = ''.$array_tributo[0]->importe;  
                }                

        }
        else {


            foreach($array_tributo as $clave => $valor)
            {
                if (strtoupper($valor->descripcion) == $impuesto) {
                    $importe = ''.$valor->importe;                
                }
            }
                if (strtoupper($array_tributo[0]->descripcion) == 'IMPUESTOS PROVINCIALES' && $impuesto == 'IIBB') {
                    $importe = ''.$array_tributo[0]->importe;  
                }                


                if (strtoupper($array_tributo[1]->descripcion) == 'IMPUESTOS PROVINCIALES' && $impuesto == 'IIBB2') {
                    $importe = ''.$array_tributo[1]->importe;  
                }                


        }

    	
    	return $importe;
    }


}

