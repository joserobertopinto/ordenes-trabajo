<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdenesTrabajoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ordenes Trabajos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordenes-trabajo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ordenes Trabajo'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_ordenes_trabajo',
            'nro_orden_trabajo',
            'fecha_hora_creacion',
            'fecha_hora_finalizacion',
            'descripcion:ntext',
            //'id_historial_estado_orden_trabajo',
            //'id_tipo_trabajo',
            //'id_inmueble',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
