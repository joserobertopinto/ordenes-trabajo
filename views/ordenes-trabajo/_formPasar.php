<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\alert\Alert;
use app\models\Estado;

/* @var $this yii\web\View */
/* @var $model app\models\Historial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-lg-12">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <?php foreach(Yii::$app->session->getFlash('success') as $key => $value )
                    echo $value;
            ?>

        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('danger')): ?>
        <div class="alert alert-danger alert-dismissable">
            <?php
                $var = Yii::$app->session->getFlash('danger'); 
                foreach($var as $key => $value )
                    echo $value;
            ?>
        </div>
    <?php endif; ?>
</div>

<div class='card card-body'>

    <?php $form = ActiveForm::begin([
            'action' => Yii::$app->getUrlManager()->createUrl(['ordenes-trabajo/pasar']),
            'id' => 'id-form-pasar',
            'errorCssClass' => 'error-validate',
        ]); ?>

    <?= $form->field($model, 'id_ordenes_trabajo')->hiddenInput(['id' => 'id-orden-for-pase'])->label(false) ?>

    <?= $form->field($historial, 'id_estado')->hiddenInput(['id' => 'id-estado-for-pase'])->label(false) ?>

    <?= $form->field($model, 'comentario', ['labelOptions' => [ 'class' => 'control-label bmd-label-floating' ]])->textInput() ?>

    <?php if($historial->id_estado == Estado::ESTADO_FINALIZADO){?>
        <br>

        <?= $form->field($historial, 'parcial', ['labelOptions' => [ 'class' => 'control-label bmd-label-floating' ]])->checkBox() ?>
        
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
    <?php } ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Pasar Orden'), ['class' => 'btn btn-success', 'id' => 'submit-modal-pase']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJs('
        $(document).ready(function(){
            //agrego color a los mensajes de validación
            $(".help-block").addClass("text-danger");
        });
        $("#id-form-pase").submit(function(e) {
            e.preventDefault();    
            var formData = new FormData(this);
            url = "'.Url::to(['ordenes-trabajo/pasar']).'";
            $.ajax({
                url: url,
                type: "POST",
                beforeSend   : function(){
                    $("#submit-modal-pase").html("<span class=\"fa fa-spin fa-spinner\"></span> Procesando...");
                    $("#submit-modal-pase").prop("disabled", true);},
                data: formData,
                success: function (data) {
                    var json = JSON.parse(data);
                    $(".pasarModalContent").html( json.html );
                    //$("#pasarModal-label").html(json.titulo);
                    $("#pasarModal").modal("show");
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });'
    );
?>