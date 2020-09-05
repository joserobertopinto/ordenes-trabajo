<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdenesTrabajoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ordenes Trabajos');
$this->params['breadcrumbs'][] = $this->title;
$urlNew = Yii::$app->urlManager->createUrl(['ordenes-trabajo/create']);
?>
<div class="ordenes-trabajo-index">

<div class='card'>
    <div class="card-header-primary">
            <h4 class="card-title">
                Ordenes de Trabajo
                <?= Html::a('<i class="material-icons">library_add</i>',
                $urlNew,
                ['title'=>Yii::t('app', 'Nueva Orden'), 'class' => 'btn-header-card']); ?>
            
            </h4>
            <p class="card-category">Lista</p>
    </div>
    <div class='card-body'>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'striped' => false,
            'bordered'=>false, 
            'columns' => [
                [
                    'attribute' => 'id_ordenes_trabajo',
                    'visible'   => false
                ],
                'nro_orden_trabajo',
                'titulo',
                'fecha_hora_finalizacion',
                'descripcion:ntext',
                //'id_historial_estado_orden_trabajo',
                //'id_tipo_trabajo',
                //'id_inmueble',

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'template' => '{view}', // .' {custom}',
                    // 'visibleButtons' => [
                    //     'update' => function ($model, $key, $index) {
                    //         return $model->puedeModificar();
                    //     }
                    // ],
                
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a( '<i class="material-icons">visibility</i>',
                                [Yii::$app->urlManager->createUrl(['view', 'id' => $model->id_ordenes_trabajo])],
                                ['title' => 'ver']
                            );
                        },
                    ],
                    // 'vAlign' => 'middle',
                    // 'viewOptions' => [
                    //     'title' => $viewMsg,
                    //     'data-toggle' => 'tooltip'
                    // ],
                    // 'updateOptions' => [
                    //     'title' => $updateMsg,
                    //     'data-toggle' => 'tooltip'
                    // ],
                    // 'deleteOptions' => [
                    //     'title' => $deleteMsg,
                    //     'data-toggle' => 'tooltip'
                    // ]
                ],
            ],
        ]); ?>
    </div>
</div>

</div>
