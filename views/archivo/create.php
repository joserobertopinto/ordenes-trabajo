<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Archivo */

$this->title = Yii::t('app', 'Create Archivo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Archivos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header card-header-success">
        <h5 class="card-title">Adjuntar archivos a la orden</h4>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
