<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Archivo */
/* @var $form yii\widgets\ActiveForm */
?>

<form class="form-inline">

    <?php $form = ActiveForm::begin(['action' => Url::to('/archivo/create')]); ?>
    
        <div class="form-group">
            <?= $form->field($model, 'archivo')->fileInput()->label('Archivo') ?>
        </div>
        
        <div class="form-group">
        <?= $form->field($model, 'descripcion', ['labelOptions' => [ 'class' => 'control-label bmd-label-floating' ]])->textInput() ?>
        </div>
        
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Agregar Archivo'), ['class' => 'btn btn-success']) ?>
        </div>
    
    <?php ActiveForm::end(); ?>

</div>
<?php
    $this->registerJs("
        $('.guardar-archivo').on('click', function() {
            alert('jose');
        });
    ");
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