<?php
namespace common\models;

use Yii;

class Formato
{

    public static function fecha($fecha)
    {
    	if (strpos($fecha, '/'))
    		return $fecha;
    	$fecha = date_create($fecha);
		return date_format($fecha, 'd/m/Y');	// 31/07/2012
    }
    
	public static function textAreaToHTML($text)
	{
		$text = trim($text);
		$str_HTML = '';
		$str_array = str_split($text);
		foreach ($str_array as $char) {
			if (ord($char) == 10)
				$str_HTML .= '<br>';
			else
				$str_HTML .= $char;
			
// 			echo '[' . $char . '] = ' . ord($char) . '<br>';
		  
		}
// 		 exit();
		return $str_HTML;
	}	
    
    public static function comprobanteAbreviar($comprobante)
    {
    	$fe = $comprobante;
    	if ($fe === 'FACTURA A') $fe = 'A';
    	else if ($fe === 'FACTURA B') $fe = 'B';
    	else if ($fe === 'NOTA DE CREDITO A') $fe = 'NCA';
    	else if ($fe === 'NOTA DE CREDITO B') $fe = 'NCB';
    	else if ($fe === 'NOTA DE DEBITO A') $fe = 'NDA';
    	else if ($fe === 'NOTA DE DEBITO B') $fe = 'NDB';
    	
    	return $fe;
    }

    public static function erroresCae($str)
    {
    	$str_revisar = $str;
    
    	$pos = strpos($str_revisar, ':');
    
    	$num_error = substr($str_revisar, 0, $pos+1);
    	$str = str_replace($num_error, '<b>'.$num_error.'</b>', $str_revisar);
    
    	$str_revisar = substr($str_revisar, $pos+1);
    
    	$posibles = ['0:','1:','2:','3:','4:','5:','6:','7:','8:','9:'];
    	for ($i = 0; $i < count($posibles); $i++) {
    		$pos = 0;
    		$pos = strpos($str_revisar, $posibles[$i]);
    		 
    		if (!$pos)	continue;
    
    		$tmp = '';
    		$pos_ini = 0;
    		$c = 1;
    		while (!in_array(ord($tmp), [10,32])) {	
    			$tmp = substr($str_revisar, $pos--, 1);
    			$pos_ini = $pos;
    			$c++;
    		}
    		$num_error = substr($str_revisar, $pos_ini+1, $c+1);
    		$str = str_replace($num_error, '<br><b>'.$num_error.'</b>', $str);
    	}
    	
    	$str = str_replace('nm', 'n&uacute;m', $str);
     	$str = str_replace('ÃƒÂ¡', '&iacute;a', $str);
     	$str = str_replace('ÃƒÂ©', '&eacute;', $str);
    	$str = str_replace('ÃƒÂ­', '&iacute;', $str);
    	$str = str_replace('ÃƒÂ³', '&oacute;', $str);
    	$str = str_replace('ÃƒÂº', '&uacute;', $str);
    	$str = str_replace('parametros', 'par&aacute;metros', $str);
    
    	return $str;
    }
    public static function fechaHora($fecha)
    {
    	
    	
    	$fecha_hora = (explode(' ', $fecha));

        if (count($fecha_hora)>2) 
            return $fecha;
    	
    	$fecha = (explode('-', $fecha_hora[0]));
    	
    	$hora = $fecha_hora[1];
    	$fecha = $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0];
    	
    	if ($hora === '00:00:00') {
    		return $fecha;
    	}
    	 
    	return $fecha . ' ' . $hora;
    }

    public static function fecha_mes($fecha)
    {
// 	    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	    
	    $fecha = explode('-', $fecha);
	    
	    $fecha = explode(' ', $fecha[2])[0] . ' ' . substr($meses[$fecha[1]-1], 0, 3) . ' ' . $fecha[0];
	    
    	return $fecha;	// 20 Abr 2015
    }
    
    
    public static function cuit($cuit)
    {
		// 	30692945162
		// 	01234567891
		if (strlen($cuit) == 11) {
			
			$pri = substr($cuit, 0, 2);		// 30
			$seg = substr($cuit, 2, 8);		// 69294516
			$ter = substr($cuit, 10);		// 2
			
			$cuit = $pri .'-'. $seg .'-'. $ter;  	// 30-69294516-2
		}
		
		return $cuit;
    }
    
    
    public static function concatenar($array, $campo, $separador)
    {
	    $cadena = '';
		foreach ($array as $i) {
			$cadena .= $i->$campo . $separador;
		}
    	return $cadena;	
    }
    
    /*
     * devuelve un string completando con ceros hasta una longitud de 8 caracteres
     * ej: 678 devuelve -> 00000678
     */
    public static function numeroFactura($nro)
    {
    	$str = (String) $nro;
    	 
    	while (strlen($str) < 8) {
    		$str = '0' . $str;
    	}
    	 
    	return $str;
    	 
    }

    /*
     * se recibe un string con este formato '01/06/2015'
     * y se devuelve de la forma ... '20150601'
     */
    public static function fechaDataPickerToSql($fecha)
    {

    	if (strlen($fecha) != 10)
    		return $fecha;
    	
		$fecha = (explode('/', $fecha));
		$fecha = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];
    	
		return $fecha;
    }

    /*
     * se recibe un string con este formato '01/06/2015'
     * y se devuelve de la forma ... '20150601'
     */
    public static function fechaSqlToDataPicker($fecha)
    {
    
    	if (strlen($fecha) != 10)
    		return $fecha;
    	 
    	$fecha = (explode('-', $fecha));
    	$fecha = $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0];
    	 
    	return $fecha;
    }

    public static function generateRandomLetters()
    {
		$string = strtoupper(Yii::$app->security->generateRandomString());
	    return preg_replace('/[^a-z]+/i', '', $string);
    }
    
    
    public static function utf8_decode_all($input) {
        if (is_string($input)) {
            
            $input = utf8_decode($input);
            $input = self::specialChars($input);
            
             
        } 
        return $input;
    }    

    public static function specialChars($input) {
        if (is_string($input)) {

            $input = str_replace('¢', '&oacute;', $input);
            $input = str_replace('Ã‚Â', '', $input);
            
//            $a=explode(" ", trim($input));
//            if (count($a)>=3) {
//            if ((strtolower($a[1]) =='Pl')&&(strtolower($a[2]) =='stico')){
//                $str = $a[0] . ' ' . $a[1] . '&aacute;' . $a[2] . ' ';              
//                for ($i=3;$i<=count($a)-1; $i++){
//                    $str .= $a[$i] . ' ';
//                }
//                $input =  $str;
//            }
//            else {
//                $input =  $input;   
//            }
//        }


        } 
        return $input;        
    }
	
	/**
	 * Convierte las tildes de un texto a sus entidades HTML.
	 *
	 * @param string $cadena
	 *        	Cadena a modificar.
	 * @return string Cadena de texto con codigos html.
	 */
	public static function tildesToHtmlEntities($str) {
		
		$cadena = $str;

    	//$str = str_replace(search, replace, subject)
    	$str = str_replace('á', '&aacute;', $str);
    	$str = str_replace('é', '&eacute;', $str);
    	$str = str_replace('í', '&iacute;', $str);
    	$str = str_replace('ó', '&oacute;', $str);
    	$str = str_replace('ú', '&uacute;', $str);
		$str = str_replace('ñ', '&ntilde;', $str);

        $str = str_replace('Á', '&Aacute;', $str);
        $str = str_replace('É', '&Eacute;', $str);
        $str = str_replace('Í', '&Iacute;', $str);
        $str = str_replace('Ó', '&Oacute;', $str);
        $str = str_replace('Ú', '&Uacute;', $str);
        $str = str_replace('Ñ', '&Ntilde;', $str);

    	
   	
    	return $str;


		return str_replace ( array (
				"á",
				"é",
				"í",
				"ó",
				"ú",
				"ñ",
				"Á",
				"É",
				"Í",
				"Ó",
				"Ú",
				"Ñ",
		), array (
				"&aacute;",
				"&eacute;",
				"&iacute;",
				"&oacute;",
				"&uacute;",
				"&ntilde;",
				"&Aacute;",
				"&Eacute;",
				"&Iacute;",
				"&Oacute;",
				"&Uacute;",
				"&Ntilde;",
		), $cadena );


	}
    
	/**
	 * Convierte las entidades HTML en tildes.
	 *
	 * @param string $cadena
	 *        	Cadena a modificar.
	 * @return string Cadena de texto con tildes.
	 */
	public static function htmlEntitiesToTildes($cadena) {
		return str_replace ( array (
				"&aacute;",
				"&eacute;",
				"&iacute;",
				"&oacute;",
				"&uacute;",
				"&ntilde;",
				"&Aacute;",
				"&Eacute;",
				"&Iacute;",
				"&Oacute;",
				"&Uacute;",
				"&Ntilde;",
		), array (
				"á",
				"é",
				"í",
				"ó",
				"ú",
				"ñ",
				"Á",
				"É",
				"Í",
				"Ó",
				"Ú",
				"Ñ",
		), $cadena );
	}
	

}

