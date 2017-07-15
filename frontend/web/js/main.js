$(document).ready(function() {
	var a = $("a.navbar-brand");
	if (a.text().length >= 35) {
		a.css("font-size", "13px");
		$("li").css("font-size", "13px");
	}
});


$(function(){

	// get the click of the create button 
	$('#modalButton').click(function (){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});


$(document).ready(function() {
	$("#btnErroresFE").click();
    setInterval(function(){ $("#btnErroresFE").click(); }, 30000);
});


$('#btnErroresFE').click(function(){

	$.get('index.php?r=site/get-count-errores',function(data){
		var data = $.parseJSON(data);

// 		alert(JSON.stringify(parseInt(data)));

		var labelErroresFE = document.getElementById("labelErroresFE");
 		if (parseInt(data) > 0) {
 			if( typeof labelErroresFE !== 'undefined' && labelErroresFE !== null ){
				labelErroresFE.style.color = "#FB5F5F";
			}
 			
 		}
 		else {
 			if( typeof labelErroresFE !== 'undefined' && labelErroresFE !== null ){
				labelErroresFE.style.color = "#9d9d9d";
			} 			
 		}
		
		
	});
});

