var $errores_js = null;


function showDiv(arrayDIV) {
	
	for(i=0; i < arrayDIV.length; i++) {
		document.getElementById(arrayDIV[i]).style.display = "block" ; 
	}

}

function hideDiv(arrayDIV) {
	
	for(i=0; i < arrayDIV.length; i++) {
		document.getElementById(arrayDIV[i]).style.display = "none" ; 
	}
}