<?php

  use yii\helpers\Html;
  use yii\widgets\DetailView;
  use kartik\grid\GridView;
  use yii\helpers\Url;
  use app\common\utils\Fecha;


  /* @var $this yii\web\View */
  /* @var $model app\models\OrdenesTrabajo */

  $this->title = 'Ordenes de Trabajo';

  \yii\web\YiiAsset::register($this);
  $urlEdit = Yii::$app->urlManager->createUrl(['ordenes-trabajo/update','id' => $model->id_ordenes_trabajo]);
  $urlDelete = Yii::$app->urlManager->createUrl(['ordenes-trabajo/anular','id' => $model->id_ordenes_trabajo]);
?>
<div class="ordenes-trabajo-view">
    <div class='card'>
    <div class="card-header-info">
            <h4 class="card-title"><?= strtoupper(Html::encode($model->titulo)) ?>
                <?php if($model->puedeEditarOrden()){ ?>
                  <?= Html::a('<i class="material-icons">highlight_off</i></i>',
                  $urlDelete,
                  ['title'=>Yii::t('app', 'Anular Orden'), 'class' => 'btn-header-card']).'&nbsp'; ?>

                  <?= Html::a('<i class="material-icons">edit</i></i>',
                  $urlEdit,
                  ['title'=>Yii::t('app', 'Editar Orden'), 'class' => 'btn-header-card']); ?>
                <?php } ?>
            </h4>
            <p class="card-category"><?= 'Orden Nro: '.$model->nro_orden_trabajo ?></p>
    </div>
        
        <div class='card card-body' id="id_body_view">
          <div class='row'>
            <div class="col-md-12">
              <?=
                DetailView::widget([
                  'options' => [
                    'class' => 'table detail-view table-custom'
                  ],
                  'model' => $model,
                  'attributes' => [
                    'descripcion:ntext',
                  ]
                ]);
              ?>
            </div>
          </div>
            <div class="row">
            <div class="col-md-6">
              <?=
                DetailView::widget([
                  'model' => $model,
                  'options' => [
                    'class' => 'table detail-view table-custom'
                  ],
                  'attributes' => [
                    [
                      'attribute' => 'fecha_hora_creacion',
                      'value'     => function($model){ return '<i class="material-icons">schedule</i>&nbsp;'.Fecha::convertir($model->fecha_hora_creacion);},
                      'label'     => 'Fecha de Creación',
                      'visible'   => (is_null($model->fecha_hora_creacion)) ? false : true,
                      'format'    => 'raw'
                    ],
                    [
                      'attribute' => 'fecha_hora_comienzo',
                      'value'     => function($model){ return '<i class="material-icons">schedule</i>&nbsp;'.Fecha::convertir($model->fecha_hora_comienzo);},
                      'label'     => 'Fecha de Comienzo',
                      'visible'   => (is_null($model->fecha_hora_comienzo)) ? false : true,
                      'format'    => 'raw'
                    ],
                    [
                      'attribute' => 'id_usuario_asignado',
                      'value'     => $model->getAsignadoConEstilo(),
                      'label'     => 'Usuario Asignado',
                      'format'    => 'raw'
                    ],
                    [
                      'attribute' => 'operadores',
                      'value'     => $model->getOperadoresConEstilo(),
                      'label'     => 'Responsables de la tarea',
                      'format'    => 'raw'
                    ],
                    ]
                ]);
              ?>
            </div>
            <div class="col-md-6">
            <?=
            DetailView::widget([
                'model' => $model,
                'options' => [
                    'class' => 'table detail-view table-custom'
                ],
                'attributes' => [
                    // 'descripcion:ntext',
                    [
                      'attribute' => 'fecha_hora_finalizacion',
                      'value'     => function($model){ return '<i class="material-icons">schedule</i>&nbsp;'.Fecha::convertir($model->fecha_hora_finalizacion);},
                      'label'     => 'Fecha de Finalización',
                      'visible'   => (is_null($model->fecha_hora_finalizacion)) ? false : true,
                      'format'    => 'raw'
                    ],
                    [
                        'attribute' => 'id_historial_estado_orden_trabajo',
                        'value'     => function($model){ return '<span class="badge '.$model->ultimoEstadoOrdenTrabajo->estado->colorBadge().'">'.$model->getDescripcionUltimoEstado().'</span>';},
                        'label'     => 'Estado Actual',
                        'format'    => 'raw'
                    ],
                    [
                        'attribute' => 'id_tipo_trabajo',
                        'value'     => $model->getDescripcionTipoTrabajo(),
                    ],
                    [
                        'attribute' => 'id_inmueble',
                        // 'value'     => $model->getDescripcionInmueble(),
                        'value'     => function($model){ return '<i class="material-icons">store</i>&nbsp;'.$model->getDescripcionInmueble();},
                        'format'    => 'raw'
                    ],
                ],
            ]) ?>
            </div>
            </div>
        </div>
    </div>

</div>

  <div class="card">

    <div class="card-header card-header-tabs card-header-primary">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <ul class="nav nav-tabs" data-tabs="tabs">
            <li class="nav-item">
              <a class="nav-link active show" href="#linea-tiempo" data-toggle="tab">
                <i class="material-icons">history</i> Estados de la Orden
                <div class="ripple-container"></div>
              <div class="ripple-container"></div></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#archivos" data-toggle="tab">
                <i class="material-icons">attach_file</i> Archivos Adjuntos
                <div class="ripple-container"></div>
              <div class="ripple-container"></div></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#modificaciones" data-toggle="tab">
                <i class="material-icons">edit</i> Modificaciones
                <div class="ripple-container"></div>
              <div class="ripple-container"></div></a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active show" id="linea-tiempo">

          <?= $this->render('_historial', ['model'=> $model]) ?>
        
        </div>
        <div class="tab-pane" id="archivos">
        <div class="card">
            <div class="card-body">
                <?=
                    GridView::widget([
                        'dataProvider'=> $dataProviderArchivo,
                        'filterModel' => false,
                        'summary' => '',
                        'striped' => false,
                        'bordered'=>false,
                        'columns' => [
                            [
                                'attribute' => 'nombre',
                                'value'     => function($model){return $model->getDescargaHtmlLink();},
                                'format'    => 'raw',
                                'contentOptions' => ['style' => 'width:20%']
                            ],
                            'descripcion',
                        ],
                        'pjax'=>true,
                    ]);
                ?>
            </div>
        </div>
        </div>
        <div class="tab-pane" id="modificaciones">

        <?= $this->render('_modificaciones', ['dataProviderModificaciones'=> $dataProviderModificaciones]) ?>

        </div>
      </div>
    </div><!-- END BODY TAB -->

  </div><!-- END CARD BODY TAB -->
  
</div><!-- END DIV ordenes-trabajo-view -->

<?php
  $this->registerCss('
    table th, table td{
      border-color: white!important;
    }
    table tbody tr th {
      font-weight: 500!important;
      text-align: right;
    }                    
  ');
?>