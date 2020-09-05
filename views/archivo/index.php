<div class="card">
    
    <?php if($tab){ ?>
        <div class="card-header card-header-success">
            <h5 class="card-title">Adjuntar archivos a la orden
            <button class="btn-agregar-archivo" type="button" title="Agregar Archivo" style="float: right; border: 0px;background: transparent;color:white"><i class="material-icons">library_add</i></button>
            </h5>
        </div>
    <?php } ?>
    
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