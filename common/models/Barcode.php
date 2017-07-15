<?php
namespace common\models;

/*
Datos que deber� contener el "C�digo de Barras":

- C.U.I.T. del emisor (11 caracteres).

- C�digo de tipo de comprobante (2 caracteres).

- Punto de venta (4 caracteres).

- C�digo de Autorizaci�n de Impresi�n (14 caracteres).

- Fecha de vencimiento (8 caracteres).

- D�gito verificador (1 car�cter).

*/


class Barcode
{

    public static function getCode($cuit, $codmov, $puntoVenta, $cae, $fecha)
    {
    	$data = array($cuit, $codmov, $puntoVenta, $cae, $fecha);
    	
    	if (!self::test($data)){
    		return false;
    	}
    		    	
    	$pares = 0;
    	$impares = 0;
    	$cadena = $cuit . $codmov . $puntoVenta . $cae . $fecha;
    	
		
		for($i=1; $i < strlen($cadena)+1; $i++){
			if ($i%2 == 0)
				$pares += (int) $cadena[$i-1];
			else
				$impares += (int) $cadena[$i-1];
		}
		
		$resultado = $impares*3 + $pares;
		
		$verificador = 0;
		while (($resultado + $verificador)% 10 != 0) {
			$verificador++;
		}
		
		
		return $cadena . $verificador;
		    	
    	
    }
    
    private static function test($data)
    {
    	foreach ($data as $element) {
    		if (!is_numeric($element)) {
    			return false;
    		}
    	}
    	
    	return true;
    }

    
    public static function isBarcode($barcode) {
    	
    	if (strlen($barcode) != 40)
    		return false;
    	
    	return true;
    }
    
}

