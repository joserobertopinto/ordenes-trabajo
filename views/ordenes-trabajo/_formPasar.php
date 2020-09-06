<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\alert\Alert;

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

    <?= $form->field($historial, 'observacion', ['labelOptions' => [ 'class' => 'control-label bmd-label-floating' ]])->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Pasar Orden'), ['class' => 'btn btn-success', 'id' => 'submit-modal-pase']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJs('
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
                    $(".paseModalContent").html( json.html );
                    $("#paseModal").modal("show");
                    if(json.ok)
                        $("#pase-descripcion").val("");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });'
    );
?>