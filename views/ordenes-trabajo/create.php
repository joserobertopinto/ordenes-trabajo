<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrdenesTrabajo */

$this->title = Yii::t('app', 'Orden de Trabajo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordenes Trabajos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class = "card">
    <div class="card-header card-header-primary">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
        <p class="card-category"><?= isset($model->nro_orden_trabajo)?'Orden Nro: '.$model->nro_orden_trabajo : 'Crear nueva orden de trabajo' ?></p>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model'     => $model,
            'archivo'   => $archivo,
            'dataProviderArchivo' => $dataProviderArchivo,
        ]) ?>
    </div>
</div>