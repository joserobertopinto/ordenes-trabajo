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
		// print_r($item->fecha_hora);
		// exit;
	    // if (!SessionUtil::esRegistroWeb() && !Permiso::esPerito() && $item->id_estado == SolicitudEstado::ESTADO_BORRADOR)
	    //     continue;
	    
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
							</div>
							</div>
					</li>
	    	<?php 
	}
	?>
    <!-- END timeline item -->
	<li>
		<i class="fa fa-clock-o bg-gray"></i>
	</li>	
</ul>
  