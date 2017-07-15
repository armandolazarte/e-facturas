<?php
use common\models\Formato;
use common\models\Impuestos;
use common\models\Barcode;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php

$BARCODES_ARRAY = [];
?>

<div  id="modal">
  <div onclick="function(){return false;}" id="contenido-interno"></div>
  <a href="#" class="botonErroresCerrar" onclick="<?= "hideDiv(['modal'])"?>">CERRAR</a>
</div>

<a href="#" id="btnError" class="botonErroresAbrir" 
onclick="<?= "showDiv(['modal', 'contenido-interno'])"?>">ERRORES</a>

<div onclick= ocultarBarraProgreso() onMouseOut= ocultarBarraProgreso() id="modalBarraProgreso">
<div id="facturas"></div>
  <div onclick= ocultarBarraProgreso() onMouseOut= ocultarBarraProgreso() id="barraArriba"></div>
  <div onclick= ocultarBarraProgreso() onMouseOut= ocultarBarraProgreso() id="barraAbajo"></div>
  <div onclick= ocultarBarraProgreso() onMouseOut= ocultarBarraProgreso() id="contadorPorcentaje"></div>
</div>

<script>
var opacidadModal = 9;
var cantidad_facturas_js = "<?= count($imprimir)?>";

showDiv(['modalBarraProgreso', 'barraArriba', 'contadorPorcentaje', 'barraAbajo', 'facturas']);
btnErrorHide();
// se sobreescribe la funcion check_barcode para que no haga nada
function check_barcode($BARCODE){}
</script>


<?php 

try {
	
$PAGINA_PHP = 1;
	
foreach ($imprimir as $key) {


// se obtiene el CODIGO DE BARRAS
$fecha_barcode = str_replace('-', '', explode(' ', $key['fechafactura'])[0]); 
$comprobante_fe = substr($key['comprobantecodigo'], 1);

$BARCODE_PHP = Barcode::getCode(
				$key['nrocuit'],
				$comprobante_fe,
				$key['puntoventa'],
				$key['cae'],
				$fecha_barcode
			);


//se arma la ruta del logo empresa
//$url_logo_empresa = Url::base('http') . '/' . $modelo->file;
$m = '_modelo_' . $key['modelo'] . '.';
$archivo = str_replace('.', $m, $key['file']);
$url_logo_empresa = Url::base('http') . '/' . $archivo;

//modelo de factura
$MODELO = $key['modelo'] + 1;

?>
<section>
    <div id="pagina<?= $PAGINA_PHP; ?>" class="container-<?= $MODELO . $key['letra_factura']?>">
        <div class="marco1"></div>
        <div class="marco2"></div>
        <div class="marco3"></div>
        <div class="marco4"></div>
        <div class="marco5"></div>
        <div class="marco6"></div>
        <div class="marco7"></div>
        <div class="vertical-bar"></div>
        <div class="logo" style="background: url('<?= $url_logo_empresa?>') no-repeat 0 0"></div>
        <div class="productos-servicios"><?= $key['razonsocial']?></div>
        <div class="direccion">Direcci&oacute;n</div>
        <div class="cod-postal">Cod. Postal</div>
        <div class="localidad">Localidad</div>
        <div class="provincia">Provincia</div>
        <div class="telefono">Telefono</div>
        <div class="email">E-mail</div>
        <div class="direccion2"><?= $key['calle'].' '.$key['nro'].' '.$key['piso'].' '.$key['depto'] ?></div>
        <div class="cod-postal2"><?= '(' .$key['cp'].')' ?></div>
        <div class="localidad2"><?= $key['localidadEmpresa']?></div>
        <div class="provincia2"><?= $key['provincia']?></div>
        <div class="telefono2"><?= $key['telefono']?></div>
        <div class="email2"><?= $key['email']?></div>
        <div class="url2"><?= $key['url']?></div>
        <div class="separador1">-</div>
        <div class="separador2">-</div>
        <div class="separador3">-</div>
        <div class="separador4">-</div>
        <div class="separador5">-</div>
        <div class="iva-responsable-inscripto">IVA Responsable Inscripto</div>
        <div class="fondo-tipo"></div>
        <div class="tipo"></div>
        <div class="codigo">C&Oacute;DIGO</div>
        <div class="recuadroleyenda"> La operaci&oacute;n igual o mayor a un mil pesos ($ 1.000.-) est&aacute; sujeta a retenci&oacute;n </div>
		<div class="no"><?= $key['comprobantecodigo'] ?></div>
        <div class="factura"><?= $key['comprobante_descripcion']?></div>
        <div class="numero">Nº</div>
        <div class="numero2"><?= $key['puntoventa'].' - '.Formato::numeroFactura($key['comprobantenro']) ?></div>
        <div class="fecha">Fecha:</div>
        <div class="fecha2"><?= Formato::fecha($key['fechafactura'])?></div>
        <div class="cuit">CUIT Nº:</div>
        <div class="cuit2"><?= Formato::cuit($key['nrocuit']) ?></div>
        <div class="ingreso-bruto">IIBB CONV. MULT.:</div>
        <div class="ingreso-bruto2"><?= $key['nroiibb'] ?></div>
        <div class="ingreso-bruto3">Ingresos Brutos:</div>
        <div class="inicio-actividades">Inic. Act.:</div>
        <div class="inicio-actividades2"><?= Formato::fecha($key['inicioact'])?></div>
        <div class="senores">Se&ntilde;ores:</div>
        <div class="senores2"><?= '('.$key['clienteid'].') '.$key['nombre'] ?></div>
        <div class="domicilio">Domicilio:</div>
        <div class="domicilio2"><?= $key['direccion'] ?></div>
        <div class="condiciones-venta">Condici&oacute;n de pago:</div>
        <div class="condiciones-venta2"><?= $key['condicion_pago'] = ($key['condicion_pago'] == NULL) ? $key['formapago'] : $key['condicion_pago']; ?></div>
        <div class="vencimiento">VENCIMIENTO:</div>
        <div class="vencimiento2"><?= Formato::fecha($key['caevencimiento']) ?></div>
        <div class="fecha-entrega">Fecha de Entrega:</div>
        <div class="fecha-entrega2"><?= date('d/m/Y')?></div>
        <div class="cuit3">C.U.I.T.:</div>
        <div class="cuit4"><?= Formato::cuit($key['cuit']) ?></div>
        <div class="cliente-codigo">Cliente C&oacute;digo:</div>
        <div class="cliente-codigo2"><?= '('.$key['clienteid'].')' ?></div>
<!--         <div class="ingreso-bruto4">Ingresos Brutos:</div> -->
        <div class="ingreso-bruto5"></div>
        <div class="localidad3">Localidad:</div>
        <div class="localidad4"><?= $key['localidad'] ?></div>
        <div class="iva">I.V.A.</div>
        <!--
        <div class="iva3">Responsable Inscripto</div>
        -->
        <div class="iva2"><?= $key['responsable'] ?></div>
        <div class="condiciones-pago">Condiciones de pago:</div>
        <div class="condiciones-pago2"><?= $key['condicion_pago'] = ($key['condicion_pago'] == NULL) ? $key['formapago'] : $key['condicion_pago']; ?></div>
        <div class="tabla-encabezado"></div>
        <div class="cantidad">CANTIDAD</div>
        <div class="descripcion">DESCRIPCI&Oacute;N</div>
        <div class="unitario">UNITARIO</div>
        <div class="precio-total">PRECIO TOTAL</div>
        <div class="cantidad2">CANTIDAD</div>
        <div class="descripcion2">DETALLE</div>
        <div class="unitario2">P. UNITARIO</div>
        <div class="precio-total2">IMPORTE</div>
        <div class="codigo3">C&Oacute;DIGO</div>
        <div class="descripcion3">DESCRIPCI&Oacute;N</div>
        <div class="cantidad3">UNIDADES Y CANTIDADES</div>
        <div class="unitario3">PRECIO</div>
        <div class="descuento3">% DTO.</div>
        <div class="precio-total3">IMPORTE</div>
    
        <ul class="lista-productos">
    	    <li>
    	    <?php foreach ($key['detalle'] as $i) { ?>
    	    	<span class="codigo-cell"><?php echo '('.$i['codigo'].')' ?></span>
                <span class="cantidad-cell"><?php echo $i['cantidad'] ?></span>
                <span class="detalle-cell"><?php echo Formato::utf8_decode_all($i['descripcion'])?></span>
                <span class="unitario-cell"><?= '$'.number_format($i['preciounitario'], 2, ',', '.') ?></span>
			    <span class="descuento-cell"></span>
                <span class="precio-total-cell"><?= '$'.number_format($i['subtotal'], 2, ',', '.') ?></span>
                <br/>
            <?php } ?>
            </li>
        </ul>
        
								<!-- Formato::concatenar($array, $campo, $separador) -->
        <div class="tabla-texto"><?= Formato::concatenar($key['nota'], 'descripcion', ' <br>')?></div>
        <div class="subtotal">SUBTOTAL</div>
        <div class="impuesto1"><?= 'IIBB' //IMPUESTO 1?></div>
        <div class="impuesto2"><?= 'IIBB2' //IMPUESTO 2?></div>
        <div class="impuesto3"><?= 'IMP MUNIC' //IMPUESTO 3?></div>
        <div class="impuesto4"><?= 'IMP INT' //IMPUESTO 4?></div>
        <div class="iva5">IVA </div>
        <div class="total">TOTAL</div>
        <div class="subtotal2"><?= '$'. number_format(($key['importegravado'] + $key['importenogravado']), 2, ',', '.') ?></div>

        <div class="impuesto12">
        <?php 
          $importe = Impuestos::getImporte($key['tributos'],'IIBB',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>        
        
        <div class="impuesto22">
        <?php 
          $importe = Impuestos::getImporte($key['tributos'],'IIBB2',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>
        
        <div class="impuesto32">
        <?php 
          $importe = Impuestos::getImporte($key['tributos'],'Impuestos Municipales',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>

        <div class="impuesto42">
        <?php 
          $importe = Impuestos::getImporte($key['tributos'],'Impuestos Internos',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>

        
        <div class="iva6">
        <?= ($key['importeiva'] > 0) ? '$'. number_format($key['importeiva'], 2, ',', '.') : '-' ?>        
        </div>

        <div class="total2"><?= '$'. number_format($key['importetotal'], 2, ',', '.') ?></div>



        <div class="razon-social-emite2"></div>        


<!--         <div class="exp-hab">Exp. Hab. Nº</div> -->
<!--         <div class="exp-hab2">xxx-xxxx-x-xxxx</div> -->
<!--         <div class="del">Del</div> -->
<!--         <div class="del2">0001-00000651</div> -->
<!--         <div class="al">al</div> -->
<!--         <div class="al2">0001-00000700</div> -->
        <div class="fecha-impresion">Fecha de impresi&oacute;n:</div>
        <div class="fecha-impresion2"><?= date('d/m/Y')?></div>
        
        <div class="reparto-frec"></div>
        <div class="reparto-frec2"><?= $key['reparto_frec'] ?></div>                
        
        <div class="orientacion-consumidor_">Orientaci&oacute;n al consumidor Provincia de Buenos Aires 0800-222-9042</div>
        
        
        
        
<div class="logo_pf" style="background: url('<?= Url::base('http') . '/images/rapipago.png';?>') no-repeat 0 0"></div>
        
		          <div id="barcode_COD128">
		              <svg class="barcode_new_128" 
		                jsbarcode-format="CODE128"
		                jsbarcode-value="<?= $BARCODE_PHP; ?>"
		                jsbarcode-textmargin="0"
		                jsbarcode-fontsize="9"
		                jsbarcode-height=33
		                jsbarcode-width=1
		                jsbarcode-fontoptions="bold">
		              </svg>
		          </div>
		        

                 <div id="barcode_ITF">
                      <svg class="barcode_new_ITF"
                        jsbarcode-format="ITF"
                        jsbarcode-value="<?= $key['barcode']; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-fontsize="9"
                        jsbarcode-height=33
                        jsbarcode-width=1
                        jsbarcode-fontoptions="bold">
                      </svg>
                  </div>
                      
        
            <div class="leyenda-caba">
            <?php 
                    if ($empresa->provinciaid == 0): 
                        echo '147 Teléfono Gratuito CABA, Área de Defensa y Protección al Consumidor';
                    elseif ($empresa->provinciaid == 1):
                        echo 'Orientaci&oacute;n al consumidor Provincia de Buenos Aires 0800-222-9042'; 
                    else: 
                        '';
                    endif; 
            ?>
            </div>
        
        <div class="barcode"><img id="barcode"/></div>
        <div class="vencimiento-cai">VTO.:<?= Formato::fecha($key['caevencimiento']) ?></div>
        <div class="vencimiento-cai2"></div>
        <div class="vencimiento-cai3">Vto. CAE: <?= Formato::fecha($key['caevencimiento']) ?></div>
        <div class="vencimiento-cai4">Vto. CAE: <?= Formato::fecha($key['caevencimiento']) ?></div>
        <div class="cai">CAE.:</div>
        <div class="cai2"><?= $key['cae'] ?></div>
        <div class="neto-gravado">NETO GRAVADO</div>
        <div class="neto-gravado2">0.00</div>
        <div class="neto-no-gravado">NETO NO GRAVADO</div>
        <div class="neto-no-gravado2">0.00</div>
    </div>
</section>

<?php 

/*
 *  se hace un chequeo de cada codigos de barras
 *  si es incorrecto se guarda en un array
 */

if (!Barcode::isBarcode($BARCODE_PHP)) {

	$info_error = [
			'cae' => $key['cae'],
			'nrocuit' => $key['nrocuit'],
			'comprobantenro' => Formato::numeroFactura($key['comprobantenro']),
			'comprobantecodigo' => $key['comprobantecodigo'],
			'barcode' => $BARCODE_PHP
	];
	array_push($BARCODES_ARRAY, $info_error);
}

?>

<script>
var $BARCODE_JS = "<?= $BARCODE_PHP; ?>";
var $PAGINA_JS = "<?= $PAGINA_PHP; ?>";
var $fontSize = 11;
var nav = navigator.userAgent.toLowerCase();
if((nav.indexOf("firefox") != -1) || (nav.indexOf("nt 5") != -1)){
    $fontSize = 10;
}

// $("#pagina" + $PAGINA_JS + " #barcode").JsBarcode($BARCODE_JS,{format:"CODE128",displayValue:true,fontSize:$fontSize,height:30, width: 0.5});
    /*$("#pagina2 #barcode").JsBarcode("1234567890",{format:"CODE128",displayValue:true,fontSize:11,height:30});*/


    
document.title = "(" + $PAGINA_JS + ") de (" + cantidad_facturas_js + ") Facturas";
porcentaje = parseFloat((100/parseInt(cantidad_facturas_js)) * parseInt($PAGINA_JS)).toFixed(2);
document.getElementById('contadorPorcentaje').innerHTML = "" + porcentaje + "%";
document.getElementById('facturas').innerHTML = $PAGINA_JS + " Facturas";
document.getElementById("barraArriba").style.backgroundColor = "rgba("+parseInt(parseFloat(porcentaje)*1.3)+", "+parseInt(parseFloat(porcentaje)*2.5)+", "+parseInt(parseFloat(porcentaje)*1.8)+", 0.9)";
document.getElementById("barraAbajo").style.backgroundColor = "rgba("+parseInt(parseFloat(porcentaje)*1.1)+", "+parseInt(parseFloat(porcentaje)*2.3)+", "+parseInt(parseFloat(porcentaje)*1.6)+", 0.9)";
document.getElementById("contadorPorcentaje").style.color = "rgba("+(200-parseInt(porcentaje)*2)+", "+(200-parseInt(porcentaje)*2)+", "+(200-parseInt(porcentaje)*2)+", 0.8)";
document.getElementById("facturas").style.color = "rgba("+(parseInt(porcentaje)*2)+", "+(parseInt(porcentaje)*2)+", "+(parseInt(porcentaje)*2)+", 0.4)";
document.getElementById("barraArriba").style.width = (parseInt(porcentaje)/2) + "%";
document.getElementById("barraAbajo").style.width = (parseInt(porcentaje)/2) + "%";



JsBarcode(".barcode_new_128").init();

JsBarcode(".barcode_new_ITF").init();
    


</script>

<?php
$PAGINA_PHP++;
}
} catch (Exception $e) {
	echo "No se puede imprimir esa cantidad de facturas." . $e->getMessage();
}

/*
 * al final de todo se comprueba si hay BARCODES con error
 * y en tal caso se arma un string con toda la informacion para 
 * luego pasarcelo a JS y mostrarlo en una ventana modal al usuario
 */

$errores_php = '';
$cantidad = count($BARCODES_ARRAY); 
$facturas = ($cantidad == 1) ? ' FACTURA' : ' FACTURAS';
if ($cantidad  > 0) {

	$errores_php .= "<br><br><b style='font: 18px arial; font-weight:bold;'>" . 
			$cantidad . $facturas. ' CON ERROR </b>' . 
			'(Código de barras incorrecto)<br><br>';
		
	foreach($BARCODES_ARRAY as $array){
		$errores_php .= '<br>' .
				 '<b>CODIGO: </b>' . $array['comprobantecodigo'] . ' - ' .
				 '<b>NUMERO: </b>' . $array['comprobantenro'] . ' - ' .
				 '<b>CUIT: </b>' . $array['nrocuit'] . ' - ' .
				 '<b>CAE: </b>' . $array['cae'] . ' - ' .
				 '<b>COD BARRAS: </b>' . $array['barcode'] . '<br>';
	}
	
	$errores_php .= '<br>';
?>
	
<script>
var $errores_js = null;
$errores_js = "<?= $errores_php?>";

if (opacidadModal < 0.2) {
	insertarErrores();
}
</script>

<?php

}
?>


<script>

var str_factura = (cantidad_facturas_js == 1) ? "Factura" : "Facturas" ;
var ocultar = false;

if ($PAGINA_JS == cantidad_facturas_js) {
	document.title = "(" + cantidad_facturas_js + ") " + str_factura;
	document.getElementById('facturas').innerHTML = $PAGINA_JS + " " + str_factura;
	ocultar = true;
// 	setTimeout(function(){hideDiv(['modalBarraProgreso', 'barraArriba', 'contadorPorcentaje', 'barraAbajo']);},10000);
	

}
var erroresInsertados = false;
function insertarErrores() {
	showDiv(['modal', 'contenido-interno']);
	btnErrorShow();
	document.getElementById('contenido-interno').innerHTML = $errores_js;
	erroresInsertados = true;

}

function ocultarBarraProgreso() {
	if (ocultar) {
		setInterval(function(){desvanecerModal("modalBarraProgreso")},10);
	
	}
}

function desvanecerModal(id) {

	x = parseFloat(parseFloat(opacidadModal)/10).toFixed(2);

	if (x < 0.03) {
		hideDiv([id]);
		if ($errores_js && !erroresInsertados){insertarErrores();}
		return false;
	}

	document.getElementById(id).style.opacity  = x;
	
	if (x > 0) {
		opacidadModal = parseFloat(opacidadModal) - 0.05;
	}


}

</script>