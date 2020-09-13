<?php

use app\common\utils\Fecha;
use kartik\helpers\Html;
use yii\helpers\Url;
use app\common\utils\Permiso;
use app\models\Estado;
use yii\widgets\Pjax;
use app\models\User;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
/* @var $form yii\widgets\ActiveForm */
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

?>
<style>
.timeline > li > .timeline-item {
	background: #f0f0f0; 
}

.timeline > li > .timeline-item > .timeline-header {
    border-bottom: 1px solid #ddd;
}

</style>

<div class="fiter-time-line">
    <a href="#filtro" data-toggle="collapse"><div class="stats">
        <i class="material-icons filter-icon">date_range</i> Filtrar
    </div></a>

    <div id="filtro" class="collapse">

        <?php 

            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'id-sumit-filter']);
            if(Permiso::esUsuarioSupervisor()){
                $urlSelect3 = \yii\helpers\Url::to(['/ordenes-trabajo/operadores-ajax']);

                echo $form->field($searchModelHistorial, 'operadores', [])->widget(kartik\select2\Select2::classname(), [
                    'options' => [
                        'placeholder' => 'Seleccione un operador'
                    ],
                    'value' => isset($searchModelHistorial->operadores) ? $searchModelHistorial->operadores : NULL,
                    'initValueText' => !empty($searchModelHistorial->operadores) ? User::getApellidoNombreByIdUser( $searchModelHistorial->operadores):NULL,// $searchModelHistorial->asignado->persona->getApellidoNombre() : NULL,
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
                ])->label(false);
            }
            
            echo $form->field($searchModelHistorial, 'fecha_hora_comienzo', 
                [
                    'addon'=>['prepend'=>['content'=>'<button type="button" id="button-clear-range"  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>']],
                    'options'=>['class'=>'drp-container form-group']
                ]
                )->widget(DateRangePicker::classname(), [
                    'convertFormat'=>true,
                    'pluginOptions' => ['locale' => ['format' => 'd/m/Y'],'allowClear'=>true],
                    //'useWithAddon'=>true
                ])->label(false);?>
        <?php ActiveForm::end();?>

    </div>
</div>
<?php
    $fechaHoy = date('Y-m-d');
     
?>
<?php Pjax::begin(['id' => 'id_content-time-line-estados']); ?>
<ul class="timeline">
    <?php
    $arrayFechas = []; 
	foreach ($dataProviderHistorial->getModels() as $i=>$item) {
			$collapsed ='';
            $collapse = empty($collapsed)?'collapse in':'collapse';
            
            $fechaItem = explode(' ', $item->fecha_hora_comienzo);
            $fechaItem = $fechaItem[0];
            $esTareaDeHoy = ($fechaHoy === $fechaItem);
		?>
			<!-- FECHA (timeline time label), se imprime solo sino no existe la fecha en $arrayFechas (solo se imprime una fecha por tarea)-->
        <?php if(!in_array($fechaItem, $arrayFechas)){?>
			<li class="time-label">
				<span class= "alert alert-info" >
					<?php  $fecha = Fecha::stringToDateTime($item->fecha_hora_comienzo,'Y-m-d H:i:s');
					echo "   ".date_format($fecha, "j")." de ".$meses[date_format($fecha ,"n")-1].date_format($fecha," Y");
					?>
				</span>
                <?php
                    if($esTareaDeHoy)
                        echo '<span class="badge badge-success">Hoy</span>';
                ?>
			</li>
        <?php }?>
			<!-- FIN FECHA (timeline-label) -->
			<!-- Estado -->
			<li>
				<i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"> <?=date_format($fecha, "H:i:s")?></i></span>
					<h3 class="timeline-header"><?= $item->titulo; ?></h3>
					<div class="timeline-body">
						
						<?php echo 'Operadores: <b>' . $item->getOperadoresConEstilo(). '</b> ';?>
						<?php echo '<br><span class="badge">'.$item->ultimoEstadoOrdenTrabajo->estado->descripcion.'</span>'; ?>
					</div>
					</div>
			</li>
    <?php 
        $arrayFechas[] = $fechaItem;
        }	
    ?>  <!-- END foreach -->
    <!-- END timeline item -->
	<li>
		<?= ($dataProviderHistorial->getTotalCount() == 0)?'<span style="font-style: italic;color:red; background-color:white">No se encontraron tareas.</span>':'<i class="fa fa-clock-o bg-gray"></i> '?>
	</li>	
</ul>

<?php Pjax::end(); ?>

<? 
$this->registerJs('			
    $(document).ready(function(){
        //oculto popover al cargar pagina
        $(".popover-x").css("display", "none");
        
        if($("#ordenestrabajosearch-fecha_hora_comienzo").val() != "")
            $(".collapse").collapse();
    });

    $(".applyBtn").on("click", function(){
        $( "#id-sumit-filter" ).submit();
    })

    $("#button-clear-range").on("click", function(){
        $("#ordenestrabajosearch-fecha_hora_comienzo").val("");
        $( "#id-sumit-filter" ).submit();
    })
    
    
');

$this->registerCss('
    .fiter-time-line{
        margin-bottom: 15px;
        margin-top: 0px;
    }
    .filter-icon{
        vertical-align: initial!important;
    }

    .icon-current-date {
        color: white!important;
        background: #952daf!important;
    }
    .select2-selection__clear{
        position : absolute!important;
    }
');