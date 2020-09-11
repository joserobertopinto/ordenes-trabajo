<?php

use app\common\utils\Fecha;
use kartik\helpers\Html;
use yii\helpers\Url;
use app\common\utils\Permiso;
use app\models\Estado;
use yii\widgets\Pjax;
use app\models\User;
use kartik\popover\PopoverX;
use kartik\form\ActiveForm;


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
<?php Pjax::begin(['id' => 'id_content-time-line-estados']); ?>
<ul class="timeline">
	<?php 
	
	foreach ($model->historialEstadoOrdenTrabajo as $i=>$item) {
		if($item->mostrarEstado()){
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
						<?php echo '<br><span>Comentario<span>: <b>'.$item->observacion.'</b>'; ?>
												
						<?php if($item->id_historial_estado_orden_trabajo == $model->ultimoEstadoOrdenTrabajo->id_historial_estado_orden_trabajo){ ?>
								<?php 
									PopoverX::begin([
									'placement' => PopoverX::ALIGN_TOP,
									'size' => PopoverX::SIZE_LARGE,
									'toggleButton' => [
										'label'=>'<i class = "material-icons">edit</i>', 
										'class'=>'btn btn-sm btn-outline-primary',
										'style'=>'background-color: transparent;border-radius: 15px;width: 30px;
										padding: 5px;'
									],
									'id' => 'currentPopover',
									'header' => '<i class="material-icons">edit</i> Editar Comentario',
									'footer' => Html::button('Aceptar', [
											'class' => 'btn btn-sm btn-primary guardar-comentario',
											'idItem' => $item->id_historial_estado_orden_trabajo,
										])
									]);
										// form with an id used for action buttons in footer
										$form = ActiveForm::begin(['fieldConfig'=>['showLabels'=>false], 'options' => ['id'=>'kv-login-form']]);
											echo $form->field($item, 'observacion')->textArea(['placeholder'=>'', 'id' => 'comentarioEnviar']);
										ActiveForm::end();
									PopoverX::end();
								?>
							<?php if($item->showButtonAnterior()){?>
								<button 
									type="button" 
									title='Volver a <?= $item->estado->getEstadoLabel($item->estado->getEstadoAnterior()); ?>'
									rel = ""
									pregunta = "Desea volver la tarea al estado anterior?"
									class = "btn-volver-estado"
									style="float: right; border: 0px;background: transparent;color:#9d36b3">
									<i class="fa fa-arrow-down"></i>
								</button>
							<?php } ?>
							<?php if($item->showButtonProximo()){ ?>
								<button 
									type="button" 
									title='Pasar a <?= $item->estado->getEstadoLabel($item->estado->getEstadoProximo()); ?>'
									style="float: right; border: 0px;background: transparent;color:#9d36b3;">
									<i class="fa fa-arrow-up btn-pasar"></i>
								</button>
							<?php } ?>
							<?php if($item->showButtonAsignarme()){ ?>
								<button 
									type="button" 
									title='Tomar Orden'
									style="float: right; border: 0px;background: transparent;color:#9d36b3;">
									<i class="fa fa-hand-paper-o btn-tomar-tarea"></i>
								</button>
							<?php } ?>
						<?php } ?>
					
					</div>
					</div>
			</li>
		<?php }	?>  <!-- END mostrarEstado -->
	<?php }	?>  <!-- END foreach -->
    <!-- END timeline item -->
	<li>
		<i class="fa fa-clock-o bg-gray"></i>
	</li>	
</ul>

<?php Pjax::end(); ?>

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

<!-- MODAL PARA CONFIRMAR -->
<?php
    yii\bootstrap4\Modal::begin([
        'title'=>'Confirmar ',
        'id'=>'confirmarModal',
        'class' =>'modal',
        'size' => yii\bootstrap4\Modal::SIZE_DEFAULT,
    ]);
	echo "<div class='confirmaModalContent'>
		<div id='modalPregunta'></div>
		<div class='card-footer'>
		<button class='btn btn-default' data-dismiss='modal' type='button'>Cancelar</button>
		<button class='btn btn-primary btn-confirmar' type='button'>Aceptar</button>
		</div>
	</div>";
    yii\bootstrap4\Modal::end();
?>
<!-- FIN MODAL -->


<?php

	$urlPase = Url::to([
		'ordenes-trabajo/pasar',
		'id' => $model->id_ordenes_trabajo,
		'id_estado' => $model->ultimoEstadoOrdenTrabajo->estado->getEstadoProximo(),
		]);

	$urlVolver = Url::to([
		'ordenes-trabajo/volver',
		'id' => $model->id_ordenes_trabajo,
		]);
	
	$urlTomarTarea = Url::to([
		'ordenes-trabajo/tomar-tarea',
		'id' => $model->id_ordenes_trabajo,
		'id_usuario' => User::getCurrentUserId(),
	]);

	$urlEditarComentario = Url::to([
		'historial-estado/editar-comentario',
	]);

  	$js = '//open modal pasar estado
			$(".btn-pasar").on("click", function(){
				url = "'.$urlPase.'"
				$.post( url, function( data ) {
					var json = JSON.parse(data);
					$(".pasarModalContent").html( json.html );
					$("#pasarModal-label").html(json.titulo);
					$("#pasarModal").modal("show");
				});
			});
			
			$(".btn-volver-estado").on("click", function(){
				$("#modalPregunta").html($(this).attr("pregunta") );
				$("#confirmarModal").modal("show");
			});

			$(".btn-confirmar").on("click", function(){
				url = "'.$urlVolver.'";
				$.post( url, function( data ) {
					$("#confirmarModal").modal("hidden");
				});
			});

			$(".btn-tomar-tarea").on("click", function(){
				url = "'.$urlTomarTarea.'"
				$.post( url, function( data ) {
					// var json = JSON.parse(data);
					// $(".pasarModalContent").html( json.html );
					// $("#pasarModal-label").html(json.titulo);
					// $("#pasarModal").modal("show");
				});
			});
			$(document).ready(function(){
				//oculto popover al cargar pagina
				$(".popover-x").css("display", "none");
			});

			$(".guardar-comentario").on("click", function(){
				idItem = $(this).attr("idItem");
				data = { "comentario" : $("#comentarioEnviar").val() };
				url = "'.$urlEditarComentario.'?id="+idItem;

				$.post( url,data, function( data ) {
					var json = JSON.parse(data);
					if(json.ok)
						location.reload();
					else
						alert(json.mensaje);
				});
			});
	  ';
		  

  $this->registerJS($js);

  $css = '
          #w1-filters, thead{
              display:none;
		  }
		  #modalPregunta{
			text-align: center;
			margin:40px;
			font-size: 16px;
		  }
		  
  ';
  $this->registerCss($css);
?>
  