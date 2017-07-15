


function imprimir() { 
	msgHide(); 
	$('#btn').hide(); 
	btnErrorHide();	
	javascript:window.print();
	$('#btn').show(); 
	btnErrorShow();
}

function msgShow() { 
	$('#msg').show();
}

function msgHide() { 
	$('#msg').hide();
}

function btnErrorShow() {
	if ($errores_js && $errores_js.length > 0) {
		$('#btnError').show();
	}
}

function btnErrorHide() { 
	$('#btnError').hide();
}


function check_barcode($BARCODE) {

	var str_cae = '';
	var str_cuit = '';
	
	if ($BARCODE.length != 40) {

		str_cuit = ($cuit_js.length != 11) ? 'VERIFIQUE EL CUIT = ' + $cuit_js + '\n\n' : '';

		str_cae = ($cae_js == 0) ? 'VERIFIQUE EL CAE = ' + $cae_js : '';
		
		alert('EL CODIGO DE BARRAS NO ES CORRECTO.\n\n'
				+ 'COD. BARRAS = ' + $BARCODE + '\n\n'
				+ str_cuit 
				+ str_cae 
				);
	}
}


msgHide();