<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Inmueble;
use app\models\TipoTrabajo;
use dosamigos\fileupload\FileUpload;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\OrdenesTrabajo */
/* @var $form yii\widgets\ActiveForm */
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
                // 'options' => [
                //     'placeholder' => 'Seleccione Operadores'
                // ],
                'value' => $model->listaOperadores,
                'initValueText' => $model->listaOperadoresTexts,
                'pluginOptions' => [
                    // 'allowClear' => true,
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

        <?= $form->field($model, 'id_tipo_trabajo')->widget(kartik\select2\Select2::classname(), [
            // 'initValueText' => $model->incumbenciasActualesTexts,
            // 'value'=> $model->incumbenciasActualesIDs,
            //'name' => 'Solicitud[tiposAudiencia]',
            //'id'=>'solicitud-tiposAudiencia', 
            'hideSearch' => true,
            'data' => ArrayHelper::map(TipoTrabajo::find()->orderBy('descripcion DESC')->all(),'id_tipo_trabajo','descripcion'),
            'options' => ['placeholder' => 'Seleccione tipo de trabajo a realizar'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
		]);
	    ?>

        <?= $form->field($model, 'id_inmueble')->widget(kartik\select2\Select2::classname(), [
            // 'initValueText' => $model->incumbenciasActualesTexts,
            // 'value'=> $model->incumbenciasActualesIDs,
            //'name' => 'Solicitud[tiposAudiencia]',
            //'id'=>'solicitud-tiposAudiencia',
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
                <?= $form->field($model, 'fecha_finalizacion')->textInput(['type' => 'date']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'hora_finalizacion')->textInput(['type' => 'time']) ?>
            </div>
        </div>

        <br>
            
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
                        'filterModel' => false,
                        'summary' => '',
                        'striped' => false,
                        'bordered'=>false,
                        'columns' => [
                            [
                                'attribute' => 'nombre',
                                'value'     => function($model){return $model->getDescargaHtmlLink();},
                                'format'    => 'raw'
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
                
                $("#archivoModal").on("hidden.bs.modal", function () {
                    $.pjax.reload({container:"#w1-pjax"});
                });
            ';

        $this->registerJS($js);

        $css = '
                #w1-filters, thead{
                    display:none;
                }
        ';
        $this->registerCss($css);
    ?>