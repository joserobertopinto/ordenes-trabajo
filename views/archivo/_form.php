<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\alert\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Archivo */
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
            'action' => Yii::$app->getUrlManager()->createUrl(['archivo/create']),
            'id' => 'id-form-archivo',
            'options' => ['enctype' => 'multipart/form-data'],
            'errorCssClass' => 'error-validate',
        ]); ?>

    <?= $form->field($model, 'id_ordenes_trabajo')->hiddenInput(['id' => 'id-orden-for-archivo'])->label(false) ?>

    <?= $form->field($model, 'archivo')->fileInput()->label('Archivo') ?>

    <br>

    <?= $form->field($model, 'descripcion', ['labelOptions' => [ 'class' => 'control-label bmd-label-floating' ]])->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Agregar Archivo'), ['class' => 'btn btn-success btn-guardar-archivo']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJs('
        $(document).ready(function(){
            //agrego color a los mensajes de validación
            $(".help-block").addClass("text-danger");
        });

        $("#id-form-archivo").submit(function(e) {
            e.preventDefault();    
            var formData = new FormData(this);
            url = "'.Url::to(['archivo/create']).'"
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                success: function (data) {
                    var json = JSON.parse(data);
                    $(".archivoModalContent").html( json.html );
                    $("#archivoModal").modal("show");
                    if(json.ok)
                        $("#archivo-descripcion").val("");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });'
    );

    $this->RegisterCss("
        input[type=file]{
            opacity:1!important;
            z-index:1!important;
            position:relative!important;
        }
        .field-archivo-archivo{
            margin-top: 0px!important;
        }
        .field-archivo-archivo label{
            margin-bottom: 0px!important;
        }"
    );
?>