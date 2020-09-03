<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrdenesTrabajo */

$this->title = $model->id_ordenes_trabajo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordenes Trabajos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ordenes-trabajo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_ordenes_trabajo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_ordenes_trabajo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_ordenes_trabajo',
            'nro_orden_trabajo',
            'fecha_hora_creacion',
            'fecha_hora_finalizacion',
            'descripcion:ntext',
            'id_historial_estado_orden_trabajo',
            'id_tipo_trabajo',
            'id_inmueble',
        ],
    ]) ?>

</div>
