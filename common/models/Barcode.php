<?php
namespace common\models;

/*
Datos que deberá contener el "Código de Barras":

- C.U.I.T. del emisor (11 caracteres).

- Código de tipo de comprobante (2 caracteres).

- Punto de venta (4 caracteres).

- Código de Autorización de Impresión (14 caracteres).

- Fecha de vencimiento (8 caracteres).

- Dígito verificador (1 carácter).

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

