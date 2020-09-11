<?php

use rce\material\widgets\Card;
use kartik\grid\GridView;
use app\common\utils\Fecha;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Ordenes de Trabajo';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">assignment_late</i>',
                    'color'=>'danger',
                    'title'=> $totalVencidas,
                    'subtitle'=>'Fecha de comienzo vencida',
                    'footer'=>'<div class="stats">
                            <i class="material-icons text-danger">warning</i>
                            <a href="#">Get More Space...</a>
                          </div>',
                ]); Card::end(); ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">store</i>',
                    'color'=>'success',
                    'title'=> $totalFinalizadas,
                    'subtitle'=>'Finalizadas',
                    'footer'=>'<div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                          </div>',
                ]); Card::end(); ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">info_outline</i>',
                    'color'=>'danger',
                    'title'=> $totalFinalizadasParcial,
                    'subtitle'=>'Finalizadas Parcial',
                    'footer'=>'<div class="stats">
                            <i class="material-icons">local_offer</i> Tracked from Github
                          </div>',
                ]); Card::end(); ?>
            </div>
        </div> <!--END ROW -->

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Tareas pendientes asignadas Recientemente</h4>
                        <p class="card-category">New employees on 15th September, 2016</p>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- GRILLA KARTIK -->
                        <?=
                            GridView::widget([
                                'dataProvider'=> $dataProviderAsignadas,
                                'filterModel' => false,
                                'summary' => '',
                                'striped' => false,
                                'bordered'=>false,
                                'options' => [
                                    'class' => 'gridClassWarning',
                                 ],
                                'columns' => [
                                    [
                                        'attribute' => 'id_ordenes_trabajo',
                                        'visible'   => false,
                                    ],
                                    [
                                        'attribute' => 'nro_orden_trabajo',
                                        'label'     => 'Nro.',
                                        'visible'   => true,
                                        'headerOptions' => ['style' => 'width:10%'],
                                    ],
                                    'titulo',
                                    [
                                        'attribute' => 'fecha_hora_comienzo',
                                        'label'		=> 'Comienzo',
                                        'value'		=> function ($model) {
                                                return Fecha::convertir($model->fecha_hora_comienzo);
                                            },
                                        'filter' => false,
                                    ],
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'headerOptions' => ['id' => 'headerGrilla'],
                                        'dropdown' => false,
                                        'template' => '{view}', // .' {custom}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a( '<i class="material-icons">visibility</i>',
                                                    [Yii::$app->urlManager->createUrl(['view', 'id' => $model->id_ordenes_trabajo])],
                                                    ['title' => 'ver datalle']
                                                );
                                            },
                                        ],
                                    ],
                                ],
                                'pjax'=>false,
                            ]);
                        ?>
                    </div>
                </div>
            </div><!-- END CARD ASIGNADAS RECIENTEMENTE -->

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">
                        <i class="fa fa-check-square-o"></i>&nbsp;Tareas finalizadas Recientemente
                        </h4>
                        <p class="card-category">New employees on 15th September, 2016</p>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- GRILLA KARTIK -->
                        <?=
                            GridView::widget([
                                'dataProvider'=> $dataProviderFinalizadas,
                                'filterModel' => false,
                                'summary' => '',
                                'striped' => false,
                                'bordered'=>false,
                                'options' => [
                                    'class' => 'gridClassSuccess',
                                 ],
                                'columns' => [
                                    [
                                        'attribute' => 'id_ordenes_trabajo',
                                        'visible'   => false,
                                    ],
                                    [
                                        'attribute' => 'nro_orden_trabajo',
                                        'label'     => 'Nro.',
                                        'visible'   => true,
                                        'headerOptions' => ['style' => 'width:10%'],
                                    ],
                                    'titulo',
                                    [
                                        'attribute' => 'fecha_hora_finalizacion',
                                        'label'		=> 'Finalizada',
                                        'value'		=> function ($model) {
                                                return Fecha::convertir($model->fecha_hora_finalizacion);
                                            },
                                        'filter' => false,
                                    ],
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'headerOptions' => ['id' => 'headerGrilla'],
                                        'dropdown' => false,
                                        'template' => '{view}', // .' {custom}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a( '<i class="material-icons">visibility</i>',
                                                    [Yii::$app->urlManager->createUrl(['view', 'id' => $model->id_ordenes_trabajo])],
                                                    ['title' => 'ver']
                                                );
                                            },
                                        ],
                                    ],
                                ],
                                'pjax'=>false,
                            ]);
                        ?>
                    </div>
                </div>
            </div><!-- END CARD FINALIZADAS RECIENTEMENTE -->
        </div> <!-- END ROW CARD GRILLAS-->

    </div><!-- END BODY CONTENT -->

</div><!-- END SITE INDEX -->

<?php 
    $this->registerJs("
        $(document).ready(function(){
            //fix rowpan de gridview actions para bs4
            $('#headerGrilla').attr('rowspan','1');
        });    
    ");
    $this->registerCss("
        /** fix rowpan de gridview actions para bs4 **/
        #headerGrilla, #w0-filters, #w4-filters{
            display : none!important;
        }
        .gridClassWarning table thead tr th a{
            color: #fb8c00;
        }
        .gridClassSuccess table thead tr th a{
            color: #43a047;
        }
    ");
?>
