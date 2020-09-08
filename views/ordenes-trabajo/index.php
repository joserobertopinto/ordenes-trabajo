<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estado;
use app\models\TipoTrabajo;
use app\models\OrdenesTrabajo;
use app\common\utils\Fecha;
use kartik\daterange\DateRangePicker;

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
                    'visible'   => false,
                ],
                [
                    'attribute' => 'nro_orden_trabajo',
                    'visible'   => true,
                    'headerOptions' => ['style' => 'width:10%'],
                ],
                [
                    'attribute' => 'id_tipo_trabajo',
                    'value'     => function($model){ return $model->tipoTrabajo->descripcion;},
                    'filter'    =>  ArrayHelper::map(TipoTrabajo::find()->all(), 'id_tipo_trabajo', 'descripcion'),
                    'filterType'=>  GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>[
                        'hideSearch'=>true,
                        'pluginOptions'=>['allowClear'=>true],],
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
                    'value'     => function($model){ return $model->getOperadoresAplanados();},
                    'filter'    => OrdenesTrabajo::getAllOperadoresForSelect2(),
                    'filterType'=> GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true,'placeholder'=>'Todos'],],
                    'filterInputOptions'=>['placeholder'=>'Todos'],
                ],
                [
                    'attribute' => 'fecha_hora_comienzo',
                    'label'		=> 'Fecha de Comienzo',
                    'value'		=> function ($model) {
                            return Fecha::convertir($model->fecha_hora_comienzo);
                        },
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'fecha_hora_comienzo',
                        'convertFormat' => true,
                        'useWithAddon' => false,
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'd/m/Y'
                            ],'allowClear'=>true, 'autoclose' => true,
                        ],
                    ])
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'headerOptions' => ['id' => 'headerGrilla'],
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

<?php 
    $this->registerJs("
        $(document).ready(function(){
            //fix rowpan de gridview actions para bs4
            $('#headerGrilla').attr('rowspan','1');
        });    
    ");

    $this->registerCss("
        /** fix rowpan de gridview actions para bs4 **/
        .select2-selection__clear{
            position : absolute!important;
        }
    ");
?>

