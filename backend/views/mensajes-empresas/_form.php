<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\MensajesEmpresas */
/* @var $form yii\widgets\ActiveForm */


$empresaid_count_php = (count($empresas_razon_razon)-1);

?>

<div class="mensajes-empresas-form">




	<div class="form-group">

	<div class="col-md-2">
	</div>
	
		<div class="col-md-8">
		<div class="well" style="background:#fcfcfc;">
            <?php $form = ActiveForm::begin(['id' => 'form-facturas', 'method'=>'post',
                                        'layout'=>'horizontal', 
            		'fieldConfig' => [
                                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                            /*'labelOptions' => ['class'=>''],*/
                                            'horizontalCssClasses' => [
                                                'label' => 'col-sm-4',
                                                'offset' => 'col-sm-offset-4',
                                                'wrapper' => 'col-sm-8',
                                                'error' => '',
                                                'hint' => '',
                                            ],
                                        ],
            ]) ?>

    <?= $form->field($model, 'empresaid')->textInput(['style' => 'display:none;'])->label(false) ?>
    
    <?php // $form->field($model, 'empresa')->widget(Select2::classname(), [
//         'data' => $empresas_razon_razon,
//         'language' => 'es',
    		        		
//         'options' => ['placeholder' => 'Seleccionar Empresa ...',
//         'multiple' => true],
//         'pluginOptions' => [
//             'allowClear' => true
//         ],
//     ]); 
    ?>    
    
	<?php //echo $form->field($model, 'empresa')->dropDownList($empresas_razon_razon); ?>

	
	
	
	<div class="col-md-12">
	
	
<?php	


            $dataProvider = new ActiveDataProvider([
                    'query' => $empresas,
            		'pagination' => [
            				'pagesize' => -1,
            		],
                    'sort' => ['defaultOrder' => ['razonsocial' => SORT_ASC]],
                ]);

	
	Modal::begin([
// 	'header'=>'<div align="center"><h4>Fechas Facturas CAE </h4></div>',
	'id' => 'modal',
// 	'size'=>'modal-sm',

	'closeButton' => false,
	'toggleButton' => [
			'id' => 'btn-nro',
			'label' => '<b>Empresas</b>',
// 			'data-toggle' => 'tooltip',
// 			'data-placement' => 'bottom',
			'title' => 'Seleccionar Empresas',
			'class'=>'btn btn-default btn-block active',
// 			'onclick'=>'setTimeout("document.getElementById(\"facturasform-nrodde\").focus()", 530);',
	
	],
	]);	
	
	
         echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
//         'filterModel' => $search,
        'id' => 'grid',
        'columns' => [
        		[
				'attribute' => 'empresaid',
				'label' => 'ID',
		         ],
        		'razonsocial',
		['class' => 'yii\grid\CheckboxColumn'],
	]  
      
    ]); ?>
         

         <?php	
         Modal::end();
         ?>		
	
	</div>	
	
	<br><br><br>	
	
	
    <?= $form->field($model, 'titulo')->textInput(['maxlength' => 50]) ?>

    
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 15]) ?>

	<div class="col-sm-6">
	<div class="well" style="background:#FAFAFA;">
    
    <?= $form->field($model, 'vista')->textInput(['maxlength' => 100,'style'=>'width:100%;margin:0px auto;']); ?>

	<?= $form->field($model, 'sizetitulo')
		->dropDownList(['h1'=>'h1','h2'=>'h2','h3'=>'h3','h4'=>'h4','h5'=>'h5']); ?>
    
    <?= $form->field($model, 'textalign')
    	->dropDownList(['text-left'=>'text-left','text-center'=>'text-center','text-right'=>'text-right']); ?>
	
    
    <?= $form->field($model, 'colorfondo')
    	->dropDownList([
    			'alert alert-warning'=>'Amarillo',
    			'alert alert-success'=>'Verde',
    			'alert alert-info'=>'Azul',
    			'alert alert-danger'=>'Rojo',
    			'alert alert-default'=>'Vacio',
    			'thumbnail'=>'Marco - Fondo Vacio',
    			'well'=>'Gris'
    	]); 
    ?>

    	<?= $form->field($model, 'activo')->inline(true)->radioList(array(1=>'Si', 0=>'No')); ?>
    
    </div>
    </div>

	<div class="col-sm-6">
    
    <div class="well" style="background:#FAFAFA;">

    	<div align="center" style="margin:-10px auto;">
    	<b>Vigencia</b>
    	</div>
    	<br><br>
    	<?= $form->field($model, 'vigenciadesde')->widget(DatePicker::className(), [
						'inline' => false,
						'language' => 'es',
						'size' => 'sm',
						 'template' => '{addon}{input}',
						'clientOptions' => [
							'autoclose' => true,
							//'format' => 'yyyy-mm-dd',
							'format' => 'dd/mm/yyyy',
						
				    		],
						]) 
                ?>

	<?= $form->field($model, 'vigenciahasta')->widget(DatePicker::className(), [
						'inline' => false,
						'language' => 'es',
						'size' => 'sm',
						 'template' => '{addon}{input}',
						'clientOptions' => [
							'autoclose' => true,
							//'format' => 'yyyy-mm-dd',
							'format' => 'dd/mm/yyyy',
						
				    		],
						]) 

	?>
    </div>
    

	<br><br><br><br>		
    <?php // $form->field($model, 'permitecerrar')->inline(true)->radioList(array(1=>'Si', 0=>'No')); ?>

    </div>
	

	<div align="right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	<br>
    <?php ActiveForm::end(); ?>

	</div>
	</div>	
	</div>	
</div>
	
	

	

         
         
         
         
         
         
<?php

// var empresas_js = "$empresas_php";
// var emp = String(empresas_js.toString()).split(",");
// // alert(JSON.stringify(emp));

// for (i = 0; i < emp.length; i++) {
// 	alert(emp[i] + "<br>");
// }

$script = <<< JS

var empresas_js = String("$model->empresaid".toString()).split(", ");
//alert(JSON.stringify(empresas_js));		

var empresaid_count_js = "$empresaid_count_php";
//alert(empresaid_count_js);

var x = document.getElementsByName("selection[]");
var i;
for (i = 0; i < x.length; i++) {
    if (x[i].type == "checkbox") {
		if (empresas_js.indexOf(x[i].value) != -1) {
        	x[i].checked = true;
		}
    }
}		

if (empresas_js == 'TODAS') {
	for (i = 0; i < x.length; i++) {
	    if (x[i].type == "checkbox") {
			
	        x[i].checked = true;
			
	    }
	}		
}

		
$(function () {


         $('#empresas-button').click(function(){
//      alert($('#grid').yiiGridView('getSelectedRows'));
        var str = window.location;
		var controller = "mensajes-empresas"
		var index_controller = String(str).indexOf(controller);
        var action = String(str).substring(0, index_controller) + controller + "/seleccionar-empresas";
//         alert(action);
        $.ajax({
                url: action,
                type: 'post',
                data: {pk:$('#grid').yiiGridView('getSelectedRows')},
//              success: function (data) {
//                  alert(data);
//            }

      });
        
         });
        
  });

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
	$('#bt-subir').hide();
});  



$("#modal").on('hidden.bs.modal', function () {
            //alert($('#grid').yiiGridView('getSelectedRows'));
			var all_checked = Object.keys($('#grid').yiiGridView('getSelectedRows')).length;
			if (all_checked == empresaid_count_js) {
				document.getElementById('mensajesempresas-empresaid').value = 'TODAS';
			}
			else {
				document.getElementById('mensajesempresas-empresaid').value = $('#grid').yiiGridView('getSelectedRows');
			}

			if (document.getElementById('mensajesempresas-empresaid').value == '') {
				document.getElementById('mensajesempresas-empresaid').value = 'NINGUNA';	
			}

			document.getElementsByName("selection_all").checked = true;
			
            
    });		

JS;
$this->registerJs($script);
?>
         
         