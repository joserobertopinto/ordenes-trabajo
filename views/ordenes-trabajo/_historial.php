<?php

use app\common\utils\Fecha;
use kartik\helpers\Html;
use yii\helpers\Url;
use app\common\utils\Permiso;
use app\models\Estado;

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

<ul class="timeline">
	<?php 
	
	foreach ($model->historialEstadoOrdenTrabajo as $i=>$item) {
	    $collapsed ='';
	    $collapse = empty($collapsed)?'collapse in':'collapse';
	
	?>
		<!-- FECHA (timeline time label)-->
		<li class="time-label">
		    <span class="<?= $item->color() ?>">
		    	<?php  $fecha = Fecha::stringToDateTime($item->fecha_hora,'Y-m-d H:i:s');
		    	echo "   ".date_format($fecha, "j")." de ".$meses[date_format($fecha ,"n")-1].date_format($fecha," Y");
		        ?>
			</span>
		</li>
		<!-- FIN FECHA (timeline-label) -->
		<!-- Estado -->
		<li>
			<i class="fa fa-check-square-o <?= $item->color() ?>" aria-hidden="true"></i>
			<div class="timeline-item">
				<span class="time"><i class="fa fa-clock-o"> <?=date_format($fecha, "H:i:s")?></i></span>
				<h3 class="timeline-header"><?= $item->estado->descripcion; ?></h3>
				<div class="timeline-body">
					
					<?php echo 'Transferido por: <b>' . $item->usuario->persona->getApellidoNombre() . '</b> ';?>
					<?php echo '<br><span>Observación<span>: <b>'.$item->observacion.'</b>'; ?>
					
					<?php if($item->id_historial_estado_orden_trabajo == $model->ultimoEstadoOrdenTrabajo->id_historial_estado_orden_trabajo){ ?>
						<?php if($item->showButtonAnterior()){?>
							<button 
								type="button" 
								title='Volver a <?= $item->estado->getEstadoLabel($item->estado->getEstadoAnterior()); ?>' 
								style="float: right; border: 0px;background: transparent;color:#9d36b3">
								<i class="fa fa-arrow-down"></i>
							</button>
						<?php } ?>
						<?php if($item->showButtonProximo()){ ?>
							<button 
								type="button" 
								title='Pasar a <?= $item->estado->getEstadoLabel($estadoProximo()); ?>'
								style="float: right; border: 0px;background: transparent;color:#9d36b3;">
								<i class="fa fa-arrow-up btn-pasar"></i>
							</button>
						<?php } ?>
					<?php } ?>
				
				</div>
				</div>
		</li>
	<?php }	?>  <!-- END foreach -->
    <!-- END timeline item -->
	<li>
		<i class="fa fa-clock-o bg-gray"></i>
	</li>	
</ul>

<!-- MODAL PARA PASAR ESTADO -->
<?php
    yii\bootstrap4\Modal::begin([
        'title'=>'Pasar a ',
        'id'=>'pasarModal',
        'class' =>'modal',
        'size' => yii\bootstrap4\Modal::SIZE_LARGE,
    ]);
    echo "<div class='pasarModalContent'></div>";
    yii\bootstrap4\Modal::end();
?>
<!-- FIN MODAL -->

<?php
	$urlPase = Url::to([
		'ordenes-trabajo/pasar',
		'id' => $model->id_ordenes_trabajo,
		'id_estado' => $model->ultimoEstadoOrdenTrabajo->estado->getEstadoProximo(),
		]);
  	$js = '//open modal alta archivos
          $(".btn-pasar").on("click", function(){
              url = "'.$urlPase.'"
              $.post( url, function( data ) {
                  var json = JSON.parse(data);
				  $(".pasarModalContent").html( json.html );
				  $("#pasarModal-label").html(json.titulo);
                  $("#pasarModal").modal("show");
              });
          });
        //   $("#pasarModal").on("hidden.bs.modal", function () {
        //       $.pjax.reload({container:"#w1-pjax"});
        //   });
      ';

  $this->registerJS($js);

  $css = '
          #w1-filters, thead{
              display:none;
          }
  ';
  $this->registerCss($css);
?>
  