<?php
use common\models\Formato;
use common\models\Impuestos;
use common\models\Barcode;
use common\models\Numbers;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
// ---------------- VARIABLES LOCALES PHP --------------------------

//se arma la ruta del logo empresa 
$m = '_modelo_' . $modelo->modelo . '.';
$archivo = str_replace('.', $m, $modelo->file);
$url_logo_empresa = str_replace('frontend', 'backend', Url::base('http') . '/' . $archivo);
$url_logo_empresa = str_replace('e-facturas', 'empresas.e-facturas', $url_logo_empresa);

//modelo de factura
$MODELO = $modelo->modelo + 1;

$number = new Numbers();

// se obtiene el CODIGO DE BARRAS
$fecha_barcode = str_replace('-', '', explode(' ', $model->fechafactura)[0]); 
$comprobante_fe = substr($comprobante->codigo, 1);

$BARCODE_PHP = Barcode::getCode(
        $empresa->nrocuit,
        $comprobante_fe,
        $puntoventa->puntoventa,
        $pie->cae,
        $fecha_barcode
      );

// ---------------- VARIABLES LOCALES PHP --------------------------

?>


<section>
    <div id="pagina1" class="container-<?= $MODELO . $letra_factura?>">
        <div class="marco1"></div>
        <div class="marco2"></div>
        <div class="marco3"></div>
        <div class="marco4"></div>
        <div class="marco5"></div>
        <div class="marco6"></div>
        <div class="marco7"></div>
        <div class="vertical-bar"></div>
        <div class="logo" style="background: url('<?= $url_logo_empresa?>') no-repeat 0 0"></div>
        <div class="productos-servicios"><?= $empresa->razonsocial?></div>
        <div class="direccion">Direcci&oacute;n</div>
        <div class="cod-postal">Cod. Postal</div>
        <div class="localidad">Localidad</div>
        <div class="provincia">Provincia</div>
        <div class="telefono">Tel&eacute;fono</div>
        <div class="email">E-mail</div>
        <div class="direccion2"><?= $empresa->calle.' '.$empresa->nro.' '.$empresa->piso.' '.$empresa->depto ?></div>
        <div class="cod-postal2"><?= '(' .$empresa->cp. ')' ?></div>
        <div class="localidad2"><?= $empresa->localidad?></div>
        <div class="provincia2"><?= isset($provincias->descripcion)?></div>
        <div class="telefono2"><?= $empresa->telefono?></div>
        <div class="email2"><?= $empresa->email?></div>
        <div class="url2"><?= $empresa->url?></div>
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
        <div class="no"><?= $comprobante->codigo ?></div>
        <div class="factura"><?= $comprobante->descripcion?></div>
        <div class="numero">N&deg;</div>
        <div class="numero2"><?= $puntoventa->puntoventa.' - '.Formato::numeroFactura($model->comprobantenro) ?></div>
        <div class="fecha">Fecha:</div>
        <div class="fecha2"><?= Formato::fecha($model->fechafactura)?></div>
        <div class="cuit">CUIT N&deg;:</div>
        <div class="cuit2"><?= Formato::cuit($empresa->nrocuit) ?></div>
        <div class="ingreso-bruto">IIBB CONV. MULT.:</div>
        <div class="ingreso-bruto2"><?= $empresa->nroiibb ?></div>
        <div class="ingreso-bruto3">Ingresos Brutos:</div>
        <div class="inicio-actividades">Inic. Act.:</div>
        <div class="inicio-actividades2"><?= Formato::fecha($empresa->inicioact)?></div>
        <div class="senores">Se&ntilde;ores:</div>
        <div class="senores2"><?= '('.$model->clienteid.') '.$model->nombre ?></div>
        <div class="domicilio">Domicilio:</div>
        <div class="domicilio2"><?= utf8_decode($model->direccion) ?></div>
        <div class="condiciones-venta">Condici&oacute;n de pago:</div>
        <div class="condiciones-venta2"><?= $model->condicion_pago = ($model->condicion_pago == NULL) ? $formaspago->descripcion : $model->condicion_pago; ?></div>
        <div class="vencimiento">VENCIMIENTO:</div>
        <div class="vencimiento2"><?= Formato::fecha($pie->caevencimiento) ?></div>
        <div class="fecha-entrega">Fecha de Entrega:</div>
        <div class="fecha-entrega2"><?= date('d/m/Y')?></div>
        <div class="cuit3">C.U.I.T.:</div>
        <div class="cuit4"><?= Formato::cuit($receptor->cuit) ?></div>
        <div class="cliente-codigo">Cliente C&oacute;digo:</div>
        <div class="cliente-codigo2"><?= '('.$model->clienteid.')' ?></div>
<!--         <div class="ingreso-bruto4">Ingresos Brutos:</div> -->
        <div class="ingreso-bruto5"></div>
        <div class="localidad3">Localidad:</div>
        <div class="localidad4"><?= $model->localidad ?></div>
        
        <div class="iva">I.V.A.:</div>
        <!--
        <div class="iva3">Responsable Inscripto</div>
        -->
        <div class="iva2"><?= $responsablecli->responsable ?></div>
        <div class="condiciones-pago">Condiciones de pago:</div>
        <div class="condiciones-pago2"><?= $model->condicion_pago = ($model->condicion_pago == NULL) ? $formaspago->descripcion : $model->condicion_pago; ?></div>
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
        <div class="cantidad3">CANTIDAD</div>
        <div class="unitario3">PRECIO</div>
        <div class="descuento3">% DTO.</div>
        <div class="precio-total3">IMPORTE</div>
        <ul class="lista-productos">
            <?php foreach ($item as $i) { ?>
                <li>
                    
                    <span class="cantidad-cell"><?= $i->cantidad ?></span>
                    <span class="detalle-cell"><?= Formato::utf8_decode_all($i->descripcion) ?></span>
                    <span class="unitario-cell"><?= '$'.number_format($i->preciounitario, 2, ',', '.') ?></span>
                    
                    <span class="precio-total-cell"><?= '$'.number_format($i->subtotal, 2, ',', '.') ?></span>
                </li>
  
             <?php } ?>
            

        </ul>
<!--                                 Formato::concatenar($array, $campo, $separador) -->
        <div class="tabla-texto"><?= Formato::concatenar($nota, 'descripcion', ' <br>')?></div>
        <div class="subtotal">SUBTOTAL</div>
        <div class="impuesto1"><?= 'IIBB' //IMPUESTO 1?></div>
        <div class="impuesto2"><?= 'IIBB2' //IMPUESTO 2?></div>
        <div class="impuesto3"><?= 'IMP MUNIC' //IMPUESTO 3?></div>
        <div class="impuesto4"><?= 'IMP INT' //IMPUESTO 4?></div>
        <div class="iva5">IVA </div>
        <div class="total">TOTAL</div>
        <div class="subtotal2"><?= '$'.number_format(($pie->importegravado + $pie->importenogravado), 2, ',', '.') ?></div>
        

        <div class="impuesto12">
        <?php 
          $importe = Impuestos::getImporte($tributo,'IIBB',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>        
        
        <div class="impuesto22">
        <?php 
          $importe = Impuestos::getImporte($tributo,'IIBB2',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>
        
        <div class="impuesto32">
        <?php 
          $importe = Impuestos::getImporte($tributo,'Impuestos Municipales',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>
        
        <div class="impuesto42">
        <?php 
          $importe = Impuestos::getImporte($tributo,'Impuestos Internos',1);
          echo ($importe != '') ? '$'. number_format($importe, 2, ',', '.') : '-';
        ?>
        </div>
        
        <div class="iva6">
        <?= ($pie->importeiva > 0) ? '$'. number_format($pie->importeiva, 2, ',', '.') : '-' ?>        
        </div>



        <div class="total2"><?= '$'. number_format($pie->importetotal, 2, ',', '.') ?></div>
	<div class="numeros-letras"><?= 'SON PESOS: ' . $number->to_word(number_format($pie->importetotal, 2, ',', '.')) ?></div>

        <div class="razon-social-emite2"></div>

<!--         <div class="exp-hab">Exp. Hab. N&deg;</div> -->
<!--         <div class="exp-hab2">xxx-xxxx-x-xxxx</div> -->
<!--         <div class="del">Del</div> -->
<!--         <div class="del2">0001-00000651</div> -->
<!--         <div class="al">al</div> -->
<!--         <div class="al2">0001-00000700</div> -->
        <div class="fecha-impresion">Fecha de impresi&oacute;n:</div>
        <div class="fecha-impresion2"><?= date('d/m/Y')?></div>
        
        <div class="reparto-frec"></div>
        <div class="reparto-frec2"><?= $model->reparto . ' ' . $model->frecuencia ?></div>        
        
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
                        jsbarcode-value="<?= $model->barcode; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-fontsize="9"
                        jsbarcode-height=33
                        jsbarcode-width=1
                        jsbarcode-fontoptions="bold">
                      </svg>
                  </div>
              

                  


            <div class="barcode"><img id="barcode"/></div>
            <div class="cai">CAE.:</div>
            <div class="cai2"><?= $pie->cae ?></div>
            <div class="vencimiento-cai3">Vto. CAE: <?= Formato::fecha($pie->caevencimiento) ?></div>
                
            <div class="leyenda-caba">
            <?php 
                    if ($empresa->provinciaid == 0): 
                        echo '147 Tel&eacute;fono Gratuito CABA, &Aacute;rea de Defensa y Protecci&oacute;n al Consumidor';
                    elseif ($empresa->provinciaid == 1):
                        echo 'Orientaci&oacute;n al consumidor Provincia de Buenos Aires 0800-222-9042'; 
                    else: 
                        '';
                    endif; 
            ?>
            </div>                      
            
            <div class="razon-social-emite">
                Raz&oacute;n Social del que emite -
                <?php 
                if ($MODELO != '4' and $letra_factura != 'B') {
                    if (strlen($empresa->razonsocial) >= 22) {
                        echo "<br>";
                    }
                }
                ?>
                <?= $empresa->razonsocial?>
            <br> C.U.I.T. N&deg; <?=    Formato::cuit($empresa->nrocuit) ?>
            </div>          
        

        <div class="vencimiento-cai">Vto. CAE: <?= Formato::fecha($pie->caevencimiento) ?></div>
        <div class="vencimiento-cai2"></div>
        <div class="vencimiento-cai4">Vto. CAE: <?= Formato::fecha($pie->caevencimiento) ?></div>
        <div class="neto-gravado">NETO GRAVADO</div>
        <div class="neto-gravado2">0.00</div>
        <div class="neto-no-gravado">NETO NO GRAVADO</div>
        <div class="neto-no-gravado2">0.00</div>
    </div>
</section>

<script>
var $cae_js =  "<?= $pie->cae?>";
var $cuit_js =  "<?= $empresa->nrocuit?>";
var $BARCODE_JS = "<?= $BARCODE_PHP; ?>";


//=====================================================================
//===================== FACTURAS DEBUGGER =============================
    
//=====================================================================
//=====================================================================

    
var $fontSize = 11;
var nav = navigator.userAgent.toLowerCase();

// determinar si el navegador el firefox o el SO es win xp
if((nav.indexOf("firefox") != -1) || (nav.indexOf("nt 5") != -1)){
    $fontSize = 10;
}

// $("#pagina1 #barcode_test").JsBarcode(
//  $BARCODE_JS,{
//      format:"CODE128",displayValue:true,fontSize:parseInt($font_debug_js), height:parseFloat($height_debug_js), width:parseFloat($width_debug_js)
//  }
// );

//$("#pagina1 #barcode").JsBarcode($BARCODE_JS,{format:"CODE128",displayValue:true,fontSize:$fontSize,height:30, width: 0.5});
    /*$("#pagina2 #barcode").JsBarcode("1234567890",{format:"CODE128",displayValue:true,fontSize:11,height:30});*/


JsBarcode(".barcode_new_128").init();

JsBarcode(".barcode_new_ITF").init();


</script>

<style>
.barcode_1 img{
  display: block;
}            
 
.container-3A .barcode_1 {
  top: 1150px;
  left: 247px;
  height: 45px;
  overflow: hidden;
  width: 1284px;
  display: block;
}            
.container-4A .barcode_1 {
  top: 1140px;
  left: 240px;
  height: 50px;
  overflow: hidden;
  width: 1850px;
  display: block;
}


.container-4A .cai_debbug {
  top: 1145px;
  left: 57px;
  font-size: 0.77em;
  font-weight: bold;
  display: block;
}

.container-4A .cai2_debbug {
  top: 1145px;
  left: 93px;
  font-size: 0.77em;
  font-weight: bold;
  display: block;
}


.container-3A .cai_debbug {
  top: 1158px;
  left: 61px;
  font-size: 0.75em;
  font-weight: bold;
  display: block;
}

.container-3A .cai2_debbug {
  top: 1158px;
  left: 93px;
  font-size: 0.75em;
  font-weight: bold;
  display: block;
}
            
.container-3A .vencimiento-cai3_debbug {
  top: 1140px;
  left: 60px;
  font-size: 0.75em;
  font-weight: bold;
  display: block;
}
</style>
