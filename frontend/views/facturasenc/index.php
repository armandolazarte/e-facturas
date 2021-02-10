<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use \yii\jui\DatePicker;
use yii\bootstrap\ActiveForm;
use common\models\Formato;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Facturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturasenc-index">

    <h1><?php // Html::encode($this->title) ?></h1>   

    <?php if ($dataProvider == '') {
        Echo $msg;
    } else { ?>
    
    <?php
		Modal::begin([
		'header' => '<center><b><span class="glyphicon glyphicon-search"></span> Filtrar Busqueda</b></center>',
		//'size' => "modal-sm",
		'toggleButton' => ['label' => '<span class="glyphicon glyphicon-search"></span> Filtrar Busqueda', 'class'=>'btn btn-success'],
	]); ?>  

    <div class="row">
        <div class="col-sm-8">
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
            
            						                <?= $form->field($search, 'fchdde')->widget(DatePicker::className(), [
												'inline' => false,
												'language' => 'es',
												'size' => 'sm',
												 'template' => '{addon}{input}',
												'clientOptions' => [
													'autoclose' => true,
						// 							'format' => 'yyyy-mm-dd',
													'format' => 'dd/mm/yyyy',
												
										    		],
												]) 
						                ?>
						                <?= $form->field($search, 'fchhta')->widget(DatePicker::className(), [
												'inline' => false,
												'language' => 'es',
												'size' => 'sm',
												 'template' => '{addon}{input}',
												'clientOptions' => [
													'autoclose' => true,
						// 							'format' => 'yyyy-mm-dd',
													'format' => 'dd/mm/yyyy',
												
										    		],
												]) 
				                ?>				                
            
            
                <?php // $form->field($search, 'fchdde')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) ?>
                <?php // $form->field($search, 'fchhta')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99',]) ?>
                <?= $form->field($search, 'puntoventa') ?>
                <?= $form->field($search, 'empresa') ?>
                <?= $form->field($search, 'nrodde') ?>
                <?= $form->field($search, 'nrohta') ?>
                <?= $form->field($search, 'impresa')->radioList(['-1'=>'todos','0'=>'no impresa','1'=>'impresa'])?>
                <br>
                <div class="form-group" align="right">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
			    <?php 
				    Modal::end();
			    ?>                   
    
        <div align="right">
                    <?= Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', 
            			['imprimir'], 
            			[
            				'class' => 'btn btn-warning', 
            				'name' => 'imprimir-button',
            				'title' => 'Imprimir todas',
                    		'target'=>'_blank'
						]
            		) 
            ?>
        
        </div>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'facturaid',
            [
             'attribute' => 'Fecha Factura',
             'value' => function ($data) {
                    return Formato::fecha($data->fechafactura);
                },
            ],
            [
             'attribute' => 'Empresa',
             'value' => function ($data) {
                    return $data->empresa->razonsocial;
                },
             ],
            //'receptorid',
            [
             'attribute' => 'Punto Venta',
             'value' => function ($data) {
                    return $data->puntoventa0->puntoventa;
                },
             ],
            [
             'attribute' => 'Comprobante',
             'value' => function ($data) {
                    return $data->comprobante->descripcion;
                },
             ],
            [
             'attribute' => 'Numero',
             'value' => 'comprobantenro',
            ],
            [
             'attribute' => 'Importe Total',
             'value' => function ($data) {
                    return '$ '.$data->facturaspies[0]->importetotal;
                },
             ],
            // 'clienteid',
            // 'nombre',
            // 'responsableid',
            // 'direccion',
            // 'localidad',
            // 'provinciaid',
            // 'telefono',
            // 'email:email',
            // 'url:url',
            // 'conceptoid',

                ['class' => 'yii\grid\ActionColumn',
                'template' => '{ver} {notificar}',
                'buttons' => [
                		'ver' => function ($action, $model, $key) {
                			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                					['view','id' => $model->facturaid],
                					[
                							'title' => 'Ver',
                							'target'=>'_blank',
                							'data-pjax' => '0',
                					]
                			);
                		},
                ],
           ],
            
        ],
    ]); ?>

    <?php } ?>
</div>
