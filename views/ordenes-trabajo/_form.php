<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use app\models\Inmueble;
use app\models\TipoTrabajo;
use dosamigos\fileupload\FileUpload;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\OrdenesTrabajo */
/* @var $form yii\widgets\ActiveForm */
$fecha_actual = date('Y-m-d');
$fecha_min = date("Y-m-d",strtotime($fecha_actual."- 1 week"));
$fecha_max = date("Y-m-d",strtotime($fecha_actual."+ 1 year")); 

?>
    <div class="form">
        <?php $form = ActiveForm::begin([
            'errorCssClass' => 'error-validate',
            'validateOnBlur'=>false,
            'validateOnChange'=>false,
            'enableAjaxValidation'=>false,
        ]); ?>

        <?= $form->field($model, 'id_ordenes_trabajo')->hiddenInput(['id' => 'input_id_orden_trabajo'])->label(false)?>

        <?= $form->field($model, 'titulo', ['labelOptions' => [ 'class' => 'control-label bmd-label-floating' ]])->textInput(['maxlength' => true])?>

        <?= $form->field($model, 'descripcion', ['labelOptions' => [ 'class' => 'control-label bmd-label-floating' ]])->textarea(['rows' => 6]) ?>
        
        <?php $urlSelect3 = \yii\helpers\Url::to(['/ordenes-trabajo/operadores-ajax']);?>
                
        <?= $form->field($model, 'listaOperadores', [])->widget(kartik\select2\Select2::classname(), [
                'options' => [
                    'placeholder' => ''
                ],
                'value' => $model->listaOperadores,
                'initValueText' => $model->listaOperadoresTexts,
                'pluginOptions' => [
                    'closeOnSelect' => true,
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'multiple' => true,
                    'ajax' => [
                        'url' => $urlSelect3,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                        'delay' => 250 // para que no haga el request inmediatamente mientras tipea y luego los cancele
                    ]
                ]
            ]);
        ?>

        <?= $form->field($model, 'id_usuario_asignado', [])->widget(kartik\select2\Select2::classname(), [
                'options' => [
                    'placeholder' => 'Seleccione un usuario'
                ],
                'value' => isset($model->id_usuario_asignado) ? $model->asignado->id_persona : NULL,
                'initValueText' => isset($model->id_usuario_asignado) ? $model->asignado->persona->getApellidoNombre() : NULL,
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'multiple' => false,
                    'ajax' => [
                        'url' => $urlSelect3,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                        'delay' => 250 // para que no haga el request inmediatamente mientras tipea y luego los cancele
                    ]
                ]
            ]);
        ?>

        <?= $form->field($model, 'id_tipo_trabajo')->widget(kartik\select2\Select2::classname(), [
            'hideSearch' => true,
            'data' => ArrayHelper::map(TipoTrabajo::find()->orderBy('descripcion DESC')->all(),'id_tipo_trabajo','descripcion'),
            'options' => ['placeholder' => 'Seleccione tipo de trabajo a realizar'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
		]);
	    ?>

        <?= $form->field($model, 'id_inmueble')->widget(kartik\select2\Select2::classname(), [
            'hideSearch' => true,
            'data' => ArrayHelper::map(Inmueble::find()->orderBy('descripcion DESC')->all(),'id_inmueble','descripcion'),
            'options' => ['placeholder' => 'Seleccione el inmueble donde se realizará el trabajo'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
		]);
        ?>
        
        <br>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'fecha_comienzo')->textInput(['type' => 'date', 'max' => $fecha_max, 'min' => $fecha_min, 'value' => $fecha_actual]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'hora_comienzo')->textInput(['type' => 'time']) ?>
            </div>
        </div>

        <br>
        <?php $origen = 'ordenes-trabajo/update';?>
        <div class="card">
            <div class="card-header card-header-success">
                <h5 class="card-title">Adjuntar archivos a la orden
                <button class="btn-agregar-archivo" type="button" title="Agregar Archivo" style="float: right; border: 0px;background: transparent;color:white"><i class="material-icons">library_add</i></button>
                </h5>
            </div>
            <div class="card-body">
                <?=
                    GridView::widget([
                        'dataProvider'=> $dataProviderArchivo,
                        'summary' => '',
                        'striped' => false,
                        'bordered'=>false,
                        'columns' => [
                            [
                                'attribute' => 'id_archivo',
                                'visible' => false
                            ],
                            [
                                'attribute' => 'nombre',
                                'value'     => function($model){return $model->getDescargaHtmlLink();},
                                'format'    => 'raw',
                                'contentOptions' => ['style' => 'width:20%']
                            ],
                            [
                                'attribute' => 'descripcion',
                                // 'value'     => function($model){return $model->getDescargaHtmlLink();},
                                'format'    => 'raw'
                            ],

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{delete}', // .' {custom}',
                            'visibleButtons' => [
                                'update' => function ($model, $key, $index) {
                                    return $model->puedeModificar();
                                }
                            ],
                        
                            'buttons' => [
                                'delete' => function ($url, $model) use ($origen){
                                    $url = Url::to(['archivo/delete/', 'id'=>$model->id_archivo, 'origen'=>$origen]);
                                    return Html::button('<i class="material-icons" aria-hidden="true">close</i>', [
                                            'class' => 'btn-eliminar-archivo',
                                            'onclick' => 'eliminarArchivo(this)',
                                            'rel' => $url,
                                            'pregunta' => '¿ Está seguro que desea eliminar el Archivo ?',
                                            'style' => 'border: 0; background-color: transparent; color:red;',
                                            'title' => 'Eliminar Archivo',
                                     ]);
                                },
                            ],
                        ],
                    ],
                        'pjax'=>true,
                    ]);
                ?>
            </div>
        </div>

        <br>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- MODAL PARA ALTA DE ARCHIVOS -->
    <?php
        //Modal para agregar archivos
        yii\bootstrap4\Modal::begin([
            'title'=>'Agregar archivos a la orden de trabajo',
            'id'=>'archivoModal',
            'class' =>'modal',
            'size' => yii\bootstrap4\Modal::SIZE_LARGE,
        ]);
        echo "<div class='archivoModalContent'></div>";
        yii\bootstrap4\Modal::end();
    ?>
    <!-- FIN MODAL -->

    <!-- MODAL PARA CONFIRMAR -->
    <?php
        yii\bootstrap4\Modal::begin([
            'title'=>'Confirmar ',
            'id'=>'confirmarModalArchivo',
            'class' =>'modal',
            'size' => yii\bootstrap4\Modal::SIZE_DEFAULT,
        ]);
        echo "<div class='confirmaModalArchivoContent'>
            <div id='modalPregunta'></div>
            <div class='card-footer'>
            <button class='btn btn-default' data-dismiss='modal' type='button'>Cancelar</button>
            <button class='btn btn-primary btn-confirmar-archivo' type='button'>Aceptar</button>
            </div>
        </div>";
        yii\bootstrap4\Modal::end();
    ?>
    <!-- FIN MODAL -->


    <?php
        
        $js = ' $(document).ready(function(){
                    //agrego color a los mensajes de validación
                    $(".help-block").addClass("text-danger");
                });

                //open modal alta archivos
                $(".btn-agregar-archivo").on("click", function(){
                    url = "'.Url::to(['archivo/create', 'id_ordenes_trabajo' => $model->id_ordenes_trabajo]).'"
                    $.post( url, function( data ) {
                        var json = JSON.parse(data);
                        $(".archivoModalContent").html( json.html );
                        $("#id-orden-for-archivo").val($("#input_id_orden_trabajo").val());
                        $("#archivoModal").modal("show");
                    });
                });

                $(".btn-confirmar-archivo").on("click", function(){
                    url = $(this).attr("rel");
                    $.post( url, function( data ) {
                        $("#confirmarModalArchivo").modal("hide");
                        $.pjax.reload({container:"#w1-pjax"});
                    });
                });
                

                $("#archivoModal").on("hidden.bs.modal", function () {
                    $.pjax.reload({container:"#w1-pjax", timeout: false});
                });
            ';

        $this->registerJS($js);
        
        //registro pos_end para no perder el binding
        $script = '                    
        function eliminarArchivo(){
            $(".btn-eliminar-archivo").on("click", function(){
                    r = $(this).attr("rel");
                    $(".btn-confirmar-archivo").attr("rel", r);
                    $("#modalPregunta").html($(this).attr("pregunta"));
                    $("#confirmarModalArchivo").modal("show");
                });
        }';    
        
        $this->registerJs($script, View::POS_END); 

        $css = '
            #w1-filters, thead{
                display:none;
            }
            .select2-selection__clear{
                position : absolute!important;
            }
            /** fix rowpan de gridview actions para bs4 **/
            .select2-selection__clear{
                position : absolute!important;
            }
        ';
        
        $this->registerCss($css);
    ?>