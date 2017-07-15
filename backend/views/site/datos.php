<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
// use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Mis Datos';
// $this->params['breadcrumbs'][] = $this->title;
$listPrestador=ArrayHelper::map($prestadores,'conceptoid','descripcion');
$listResponsable=ArrayHelper::map($responsables,'responsableid','responsable');
$listProvincias=ArrayHelper::map($provincias,'provinciaid','descripcion');

?>

    <?php 
    
    	if (Yii::$app->session->getAllFlashes() !== null) {
	    	foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
				echo '<div onload="alert("ladkfjadslkfjaslkfjsadlfkj")" class="alert alert-' . $key . '">' . $message . '</div>';
			}
    	}
	?>

<?php $form = ActiveForm::begin(['id' => 'form-receptores', 'method'=>'post',
// 		            		'enableAjaxValidation'      => false,
							'enableClientValidation'    => true,
// 							'validateOnChange'          => false,
// 							'validateOnSubmit'          => true,
// 							'validateOnBlur'            => true,
                                        'layout'=>'horizontal', 'fieldConfig' => [
			                                            'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			                                            /*'labelOptions' => ['class'=>''],*/
			                                            'horizontalCssClasses' => [
			                                                'label' => 'col-sm-4',
			                                                'offset' => 'col-sm-offset-4',
			                                                'wrapper' => 'col-sm-12',
			                                                'error' => '',
			                                                'hint' => '',
                                            ],
                                        ],
            		]) 
?>

	<br>
	<div class="col-sm-12" align="center" >
		    
		    <div class="col-sm-3 welt">
		    	<?= Html::encode($this->title) ?>
		    </div>
		    <div class="col-sm-1 welid">
		        	<?php //echo $form->field($model, 'empresaid')->textInput(['readonly' => true]) ?>
		        	<?= 'ID ' . $model->empresaid?> 
			</div>
			
			<div class="col-sm-2">
		    	
				<output class="btn btn-block btn-lg btn-default" 
					id="sucursal_text" 
					onclick="clickSucursal()"
					title="Seleccione un punto de venta" 
					data-toggle='tooltip'
        	        data-placement='bottom'
					style='
/* 					margin: 0px auto;  */
/* 					margin-top:15px; */
/* 					padding: -40px;  */
					vertical-align: middle;
					width: 100%; 
 					height:54px;
 					list-style: none; 
					text-align: center;
					margin-left: -15px;
					color: #fff; 
  					background-color: #739FE5;  
  					font-size:26px;
					'>
				</output>
				<?= $form->field($model, 'puntoventaid')->dropDownList($puntosVenta,
					['id'=>'pv', 'style'=>'
						width: 80%;
						height:54px;
						font-size:25px;
// 						margin-top:25px;
// 						margin-right: 20px;
						margin-left: -110px;
					'])
					->label(false); 
				?>
	    	</div>
	
			<div class="col-sm-5">
				<p>
				<div id="descripcion" style="font-size:26px; color: #777" align="left" >
		<?php 
		$pv1['descripcion'] = ($pv1['descripcion'] == null) ? '<br>': $pv1['descripcion'];
		echo $pv1['descripcion'];
		?>
				</div>
				<hr size="1" style="color: #CCCCCC; margin-top: 5px;" width="100%;">
			</div>	
	    	
	    	
	    	
		    
	</div>		
	
   
	<div class="col-sm-12 wel">
	
			<div class="col-sm-6 wel" >
				<div class="col-sm-18">
            
	                <div class="col-sm-12 dist" >
	                <?= $form->field($model, 'razonsocial',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">Razon Social</span>{input}</div>'])?>;
	                </div>
	                
            		<div class="col-sm-6 dist" >
	                <?= $form->field($model, 'nrocuit',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">CUIT</span>{input}</div>'])->textInput(['maxlength'=>11]) ?>
	                </div>
	                
	                
	                <div class="col-sm-6 dist" >
	                	<?= $form->field($model, 'nroiibb',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">IIBB</span>{input}</div>'])?>;
	                </div>
	                
	                
		                <div class="col-sm-8 dist">
			                <?= $form->field($model, 'calle',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">Calle</span>{input}</div>'])?>;
						</div>
			            <div class="col-sm-4 dist">    
			                <?= $form->field($model, 'nro',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">Nº</span>{input}</div>'])->input(['class'=>'wel'])?>;
			            </div>
					
					<div class="col-sm-6 dist">
	                <?= $form->field($model, 'piso',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">PISO</span>{input}</div>'])?>;
	                </div>
	                
	                <div class="col-sm-6 dist">
	                <?= $form->field($model, 'depto',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">DEPTO</span>{input}</div>'])?>;
	                </div>
	                
	                <div class="col-sm-4 dist">
	                <?= $form->field($model, 'cp',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">CP</span>{input}</div>'])?>;
	                </div>
	                
	                <div class="col-sm-8 dist">
	                <?= $form->field($model, 'localidad',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">LOCALIDAD</span>{input}</div>'])?>;
	                </div>
	                
	                <div class="col-sm-12 dist0">
					<?= $form->field($model, 'provinciaid',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">PROVINCIA</span>{input}</div>'])->dropDownList($listProvincias,[]) ?>
	                </div>
                

				</div>
			</div>
                
            <div class="col-sm-6 wel">
	            <div class="col-sm-18 ">    
	
					
	                <div class="col-sm-12 dist" >
	                	<?php //echo $form->field($model, 'inicioact',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">INICIO ACT</span>{input}</div>'])
	                	//->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) 
	                	?>
					<?= $form->field($model, 'inicioact')->widget(DatePicker::className(), [
												'inline' => false,
												'language' => 'es',
												'size' => 'md',
												'template' => '<span class="input-group-addon colorLabel">INICIO ACT</span>{input}',
// 												 'template' => '{addon}{input}',
												'clientOptions' => [
													'autoclose' => true,
						// 							'format' => 'yyyy-mm-dd',
													'format' => 'dd/mm/yyyy',
												
										    		],
												]) 
						                ?>
	                </div>
	                
	                <div class="col-sm-12 dist" >
					<?= $form->field($model, 'telefono',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel ">TEL</span>{input}</div>'])?>;
	                </div>
	                
	                <div class="col-sm-12 dist" >
	                <?= $form->field($model, 'prestadorid',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">PRESTADOR</span>{input}</div>'])->dropDownList($listPrestador,[]) ?>
	                </div>
	                
	                <div class="col-sm-12 dist" >
	                <?= $form->field($model, 'responsableid',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">RESPONSABLE</span>{input}</div>'])->dropDownList($listResponsable,[]) ?>
	                </div>
	                
	                <div class="col-sm-12 dist" >
					<?= $form->field($model, 'email',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">@</span>{input}</div>'])?>;
					</div>
					
					<div class="col-sm-12 dist0" >
	                <?= $form->field($model, 'url',['inputTemplate' => '<div class="input-group"><span class="input-group-addon colorLabel">WEB</span>{input}</div>'])?>;
					</div>
					
				</div>		            
			</div>		            
</div>		            
            <div class="col-sm-12 welp">
            <br>    
            <div class="col-sm-4">
            </div>    
			<div class="col-sm-4">
				<?= $form->field($model, 'passwordold',[
						'inputTemplate' => '<div class="input-group">
											<span class="input-group-addon colorLabel">
											Password
											</span>{input}
											</div>'
				])->passwordInput() ?>
                </div>
                <div class="col-sm-1" align="right">
                    <?php echo Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
</div>		            

<?php
$script = <<< JS

$('#pv').hide()
check();

		
$('#pv').change(function(){
	var pvid = $(this).val();

	$.get('index.php?r=site/get-datos-empresa',{ pvid : pvid },function(data){
		var data = $.parseJSON(data);

// 		alert(JSON.stringify(data));
		
		document.getElementById('puntosventaempresas-razonsocial').value = data.razonsocial;
		document.getElementById('puntosventaempresas-nrocuit').value = data.nrocuit;
		document.getElementById('puntosventaempresas-nroiibb').value = data.nroiibb;
		
		document.getElementById('puntosventaempresas-calle').value = data.calle;
		document.getElementById('puntosventaempresas-nro').value = data.nro;
		document.getElementById('puntosventaempresas-piso').value = data.piso;
		document.getElementById('puntosventaempresas-depto').value = data.depto;
		document.getElementById('puntosventaempresas-cp').value = data.cp;
		document.getElementById('puntosventaempresas-localidad').value = data.localidad;
		
		document.getElementById('puntosventaempresas-telefono').value = data.telefono;
		document.getElementById('puntosventaempresas-inicioact').value = data.inicioact;
		document.getElementById('puntosventaempresas-provinciaid').value = data.provinciaid;
		document.getElementById('puntosventaempresas-email').value = data.email;
		document.getElementById('puntosventaempresas-url').value = data.url;
		document.getElementById('puntosventaempresas-responsableid').value = data.responsableid;
		document.getElementById('puntosventaempresas-prestadorid').value = data.prestadorid;
		
		
		
		document.getElementById("puntosventaempresas-razonsocial").focus();
		document.getElementById("puntosventaempresas-nrocuit").focus();
		document.getElementById("puntosventaempresas-razonsocial").focus();
		
		
		$('#sucursal_text').show();
		$('#sucursal_text_1').show();		
		$('#pv').hide();
		check();
		
		if (data.descripcion === null || data.descripcion === ''){
			data.descripcion = '<br>';
		}

		document.getElementById('descripcion').innerHTML = data.descripcion;
		
	});
});

function check() {
        var e = document.getElementById("pv");
        var str = e.options[e.selectedIndex].text;

		document.getElementById('sucursal_text').innerHTML = str + '  ' + "<span class='glyphicon glyphicon-pencil' style='color: #555'></span>";

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

<script>

function clickSucursal() {

// 	checkearCambiosDatos();
	$('#sucursal_text').hide();
	$('#pv').show();
	$('#pv').focus();

}
function myFunction() {
	alert('ladkfjadslkfjaslkfjsadlfkj');
}


</script>

<style>
<!--

.dist {
	height: 60px;
}

.dist0 {
	height: 35px;
}

.colorLabel {
	background-color: #E6E6F0;
	border: 1px solid #bbb;
}

.wel {
    min-height: 20px;
    padding: 10px;
    margin-bottom: 3px;
    margin-top: 3px;
	list-style: none;
    background-color: #fff;
    border-radius: 6px;
}
.welt {
    min-height: 15px;
     padding: 10px; 
	list-style: none;
    background-color: #eee;
    color: #777;
    font-size: 24px;
    border-radius: 4px;
    margin-left: 3px;
    margin-bottom: 3px;
}
.welid {
    min-height: 15px;
    padding: 10px; 
	list-style: none;
    background-color: #e0e0e0;
    color: #777;
    font-size: 24px;
    border-radius: 4px;
    margin-left: 8px;
    margin-bottom: 3px;
}
.welp {
    min-height: 15px;
    padding: 7px;
	list-style: none;
    background-color: #fff;
    border-radius: 4px;
}

.help-block {
	font-size: 12px;
    margin-top: 4px;
}
-->
</style>
