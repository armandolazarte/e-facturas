<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Modelo Factura';
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->cache->flush();

?>

<?php
$id = 'm'. $model->modelo;
$dimension_logo = json_encode($model::$dimension_logo);


$script = <<< JS

var dimension_logo_array = $dimension_logo; 
var modelo = $model->modelo;
var file_src = '$model->file';
var array_data = new Array();

// alert(typeof(array_data));

$('#pv').hide()
selectModel('$id');
check();

function changeHeightPanel() {
	if (window.outerWidth > 1008) {
		document.getElementById('panel_modelo').style.height = document.getElementById('panel_logo').offsetHeight + 'px';
	}
}
		
// changeHeightPanel();		
		
$('#pv').change(function(){
	var pvid = $(this).val();

	$.get('index.php?r=site/get-modelo-factura',{ pvid : pvid },function(data){
		var data = $.parseJSON(data);

		if (data.descripcion === null || data.descripcion === ''){
// 			alert(JSON.stringify(data));
			data.descripcion = '<br>';
		}
		
		document.getElementById('modelofactura-modelo').value = data.modelo;
		document.getElementById('descripcion').innerHTML = data.descripcion;
		var logo_id = document.getElementById('logo');
		logo_id.src = data.file;
		logo_id.width = dimension_logo_array[data.modelo-1].width;
		logo_id.height = dimension_logo_array[data.modelo-1].height;
		
		changeHeightPanel();
		window.name=1;
		window.status = 1;
		array_data = data;
// 		alert(array_data.modelo);
		
		document.getElementById('m1').style.backgroundColor = "#CCCCCC";
		document.getElementById('m2').style.backgroundColor = "#CCCCCC";
		document.getElementById('m3').style.backgroundColor = "#CCCCCC";
		
		document.getElementById('m' + String(data.modelo)).style.backgroundColor = "#337ab7";

		if (data.descripcion === null || data.descripcion === ''){
			data.descripcion = '<br>';
		}
		

		$('#sucursal_text').show();
		$('#pv').hide();
		check();
	});
});



function check() {
        var e = document.getElementById("pv");
        var str = e.options[e.selectedIndex].text;

		document.getElementById('sucursal_text').innerHTML = str + '  ' + "<span class='glyphicon glyphicon-pencil' style='margin-top:7px;font-size:28px;color: #555'></span>";

}
		
		
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
		

JS;
$this->registerJs($script);
?>

<style>

.modal-content {
	background-color: #E0E0E0;
	color: #000000;
}
</style>



<META HTTP-EQUIV="REFRESH" CONTENT="#">





<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
	echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>

<?php $form = ActiveForm::begin([
					            		'id' => 'files',
					            		'method'=>'post',
					            		'options'=>['enctype'=>'multipart/form-data'],
					            		'enableClientValidation'=> true,
					            		'enableAjaxValidation'=> false,
                                        'layout'=>'horizontal', 'fieldConfig' => [
			                                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
// 			                                            'labelOptions' => ['class'=>'col-md'],
			                                            'horizontalCssClasses' => [
			                                                'label' => 'col-sm-4',
			                                                'offset' => 'col-sm-offset-4',
			                                                'wrapper' => 'col-sm-8',
			                                                'error' => '',
			                                                'hint' => '',
                                            ],
                                        ],
            		]); 
?> 

<body onresize="myReload()">
<div class="table-responsive">
	<div class="col-md-12 ">


		<div class="col-md-2">
		</div>				
	
		<div class="col-md-4" style="height: 79px;">

		
		<?php //print_r($puntosVentaDescrip)?> 
		

			<?= $form->field($model, 'puntoventaid')->dropDownList($puntosVenta,
					['id'=>'pv', 'style'=>'
						width: 100%;
						height:50px;
						font-size:23px;
						margin-top:25px;
// 						margin-right: 20px;
// 						margin-left: -125px;
					'])
					->label(false); 
			?>
			
			
			
  
			<output class="btn btn-block btn-lg btn-default" 
					id="sucursal_text" 
					onclick="clickSucursal()"
					title="Seleccione un punto de venta" 
					data-toggle='tooltip'
        	        data-placement='bottom'

					style='
/*  					border: 2px solid #777;   */
					margin: 0px auto; 
					margin-top:7px;
					padding: 2px; 
					width: 100%; 
					height:52px;
					text-align: center;
					color: #fff; 
  					background-color: #739FE5;  
  					font-size:30px;
					'>
				</output>
		
		</div>		
		
		
		
		<div class="col-md-6">
		<p><br>
		<div id="descripcion" style="font-size:30px; color: #777">
		<?php 
		$pv1['descripcion'] = ($pv1['descripcion'] == null) ? '<br>': $pv1['descripcion'];
		echo $pv1['descripcion'];
		?>
		</div>
		<hr size="1" style="color: #CCCCCC; margin-top: 5px;" width="100%;">
		</div>			

	</div>

    <div class="col-md-6 ">
            
            <div id="panel_modelo" class="well">
            	<div class="panel-body">
			<div class="row">
			<div align="center">
				<p><b>SELECCIONAR MODELO</b></p>
				<br>
			</div>	
				
				<div class="col-sm-6 col-md-4">
				<div id="m1" onclick="selectModel('m1')" class="thumbnail panel-body" align="center" style="padding: 7px 7px 0px 7px; ">
						<img class="table-responsive" src="<?= Url::base('http') . '/images/facturas/1.jpg'?>" alt="...">

				<h4>						
				<?php Modal::begin([
					'header' => '<center><b>Modelo 1</b></center>',
					'size' => "modal-lg",
		    		'toggleButton' => [
		    			'label' => 'Modelo 1 &ensp;<span class="glyphicon glyphicon-fullscreen"></span>', 
			    		'class'=>'btn btn-default btn-sm'
		    		],

		    	]); 
			    ?>  
					<img class="table-responsive" src="<?= Url::base('http') . '/images/facturas/1.jpg'?>">
				<?php Modal::end();?>             						
				</h4>		
						
						
						
						
				</div>
				</div>
				
				<div class="col-sm-6 col-md-4">
				<div id="m2" onclick="selectModel('m2')"  class="thumbnail" align="center" style="padding: 7px 7px 0px 7px;" >
<!-- 					<a href="#" > -->
						<img class="table-responsive" src="<?= Url::base('http') . '/images/facturas/2.jpg'?>">
<!-- 					</a> -->
				<h4>						
				<?php Modal::begin([
					'header' => '<center><b>Modelo 2</b></center>',
					'size' => "modal-lg",
		    		'toggleButton' => [
		    			'label' => 'Modelo 2 &ensp;<span class="glyphicon glyphicon-fullscreen"></span>', 
			    		'class'=>'btn btn-default btn-sm'
		    		],

		    	]); 
			    ?>  
					<img class="table-responsive" src="<?= Url::base('http') . '/images/facturas/2.jpg'?>">
				<?php Modal::end();?>             						
				</h4>		
				</div>
				</div>
				
				<div class="col-sm-6 col-md-4">
				<div id="m3" onclick="selectModel('m3')" class="thumbnail" align="center" style="padding: 7px 7px 0px 7px;">
<!-- 					<a href="#" > -->
						<img class="table-responsive" src="<?= Url::base('http') . '/images/facturas/3.jpg'?>">
<!-- 					</a> -->

				<h4>						
				<?php Modal::begin([
					'header' => '<center><b>Modelo 3</b></center>',
					'size' => "modal-lg",
		    		'toggleButton' => [
		    			'label' => 'Modelo 3 &ensp;<span class="glyphicon glyphicon-fullscreen"></span>', 
			    		'class'=>'btn btn-default btn-sm'
		    		],

		    	]); 
			    ?>  
					<img class="table-responsive" src="<?= Url::base('http') . '/images/facturas/3.jpg'?>">
				<?php Modal::end();?>             						
				</h4>		
				
				</div>
				</div>
											

				
			</div>

			<div align="left">
				<?= $form->field($model, 'modelo')->textInput(['readonly' => true, 
						'style'=>'width:48%; margin:0px -4px auto; 	background-color: #fcfcfc;'
						
				]) ?>                				
			</div>
				
            </div>
	</div>
						
	</div>

	
	
	
	<div class="col-md-1">
	</div>		
	
	
	
			
    <div id="panel_logo" class="col-md-6 well">

	    <br>
			<?= mb_convert_encoding($form->field($model, 'file')->fileInput(['class'=>'breadcrumb']),'UTF-8','UTF-8') ?>                

			                
            <div class="thumbnail">
            	<div class="panel-body">
            		<div style="text-align:center">
                		<?= Html::img($model->file, [
                							'id' => 'logo',
                							'alt' => 'User avatar',
                							'width'=>$model::$dimension_logo[($model->modelo) ? $model->modelo-1 : 1]['width'] ,
                							'height'=>$model::$dimension_logo[($model->modelo) ? $model->modelo-1 : 1]['height']
                							]
                						)

                					?>
					</div>
				</div>
			</div>
					<div class="form-group" style="border-top: 1px dashed grey;">
                </div>
				
                
	    <br>	    
                <?= $form->field($model, 'passwordold')->passwordInput(['style'=>'width:100%;']) ?>

                <div class="pull-right">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            	</div>
					
	    <br>	    
	    <br>	    
	</div>				
				
            	
<?php ActiveForm::end();?>

</div>
<script>

function archivo(evt) {
		  var files = evt.target.files; // FileList object
	 
		  // Obtenemos la imagen del campo "file".
		  for (var i = 0, f; f = files[i]; i++) {
			//Solo admitimos imágenes.
			if (!f.type.match('image.*')) {
				continue;
			}
	 
			var reader = new FileReader();
	 
			reader.onload = (function(theFile) {
				return function(e) {
				  // Insertamos la imagen
				document.getElementById('logo').src = e.target.result;
// 				 document.getElementById("list").innerHTML = ['<img class="logoEmp" src="', e.target.result,'" width="200" style="position:absolute; top:13%; right:30%" title="', escape(theFile.name), '"/>'].join('');
				};
			})(f);
	 
			reader.readAsDataURL(f);
		  }
	  }
	 
	  document.getElementById('files').addEventListener('change', archivo, false);



function selectModel(id) {	  

var VALUE = (id == 'm1') ? '1' : '2';
VALUE = (id == 'm3') ? '3' : VALUE;
	
document.getElementById('modelofactura-modelo').value = VALUE;

document.getElementById('m1').style.backgroundColor = "#CCCCCC";
document.getElementById('m2').style.backgroundColor = "#CCCCCC";
document.getElementById('m3').style.backgroundColor = "#CCCCCC";
document.getElementById(id).style.backgroundColor = "#337ab7";


}

function clickSucursal() {

	//checkearCambiosDatos();
	$('#sucursal_text').hide();
	$('#pv').show();
	$('#pv').focus();

}

//function checkearCambiosDatos() {

// 	alert(document.getElementById('modelofactura-modelo').value);


// 	alert(typeof(array_data));
// 	if (typeof(array_data) !== 'undefined') {
// 		alert(array_data.modelo);
// 	}		
// 	alert(JSON.stringify(array_data));
//}


function myReload() {
    var w = window.outerWidth;
    if (window.name <= 3 && window.status == 1) {
        
		if (w <= (screen.width/2 +50) && w > (screen.width/2 -50) || w == 1007 || w == 1000) {
		    location.reload();
		    window.status = 0;
		    
		}    
    }
}

var contador=isNaN(parseInt(window.name))?1:parseInt(window.name);
// alert(contador);
contador++;
window.name=contador;
window.status = 0;
</script>




