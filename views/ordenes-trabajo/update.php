<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrdenesTrabajo */

$this->title = Yii::t('app', 'Update Ordenes Trabajo: {name}', [
    'name' => $model->id_ordenes_trabajo,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordenes Trabajos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_ordenes_trabajo, 'url' => ['view', 'id' => $model->id_ordenes_trabajo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ordenes-trabajo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
