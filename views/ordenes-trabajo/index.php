<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estado;
use app\models\TipoTrabajo;

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
    <div class='card-body table-responsive'>
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
                [
                    'attribute' => 'id_tipo_trabajo',
                    'value'     => function($model){ return $model->tipoTrabajo->descripcion;},
                    'filter'    =>ArrayHelper::map(TipoTrabajo::find()->all(), 'id_tipo_trabajo', 'descripcion'),
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>['hideSearch'=>true,'pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Todas'],
                ],
                [
                    'attribute' => 'estadoActual',
                    'value'     => function($model){ return $model->getDescripcionUltimoEstado();},
                    'filter'    =>ArrayHelper::map(Estado::find()->all(), 'id_estado', 'descripcion'),
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>['hideSearch'=>true,'pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Todas'],
                ],
                [
                    'attribute' => 'operadores',
                    'value'     => function($model){ return $model->getDescripcionUltimoEstado();},
                    'filter'    =>ArrayHelper::map(Estado::find()->all(), 'id_estado', 'descripcion'),
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>['hideSearch'=>true,'pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Todas'],
                ],
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
