<?php

  use yii\helpers\Html;
  use yii\widgets\DetailView;
  use kartik\grid\GridView;
  use yii\helpers\Url;


  /* @var $this yii\web\View */
  /* @var $model app\models\OrdenesTrabajo */

  $this->title = 'Ordenes de Trabajo';

  \yii\web\YiiAsset::register($this);
  $urlEdit = Yii::$app->urlManager->createUrl(['ordenes-trabajo/update','id' => $model->id_ordenes_trabajo]);
  $urlDelete = Yii::$app->urlManager->createUrl(['ordenes-trabajo/delete','id' => $model->id_ordenes_trabajo]);
?>
<div class="ordenes-trabajo-view">
    <div class='card'>
    <div class="card-header-info">
            <h4 class="card-title"><?= strtoupper(Html::encode($model->titulo)) ?>
            
                <button class="btn-header-card" rel=<?= $urlEdit ?> type="button" title="Eliminar Orden"><i class="material-icons">delete</i></button>

                <?= Html::a('<i class="material-icons">edit</i></i>',
                $urlEdit,
                ['title'=>Yii::t('app', 'Editar Orden'), 'class' => 'btn-header-card']); ?>
            
            </h4>
            <p class="card-category"><?= 'Orden Nro: '.$model->nro_orden_trabajo ?></p>
    </div>
        
        <div class='card card-body'>
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'descripcion:ntext',
                    'fecha_hora_creacion',
                    'fecha_hora_finalizacion',
                    [
                        'attribute' => 'id_historial_estado_orden_trabajo',
                        'value'     => $model->getDescripcionUltimoEstado(),
                        'label'     => 'Estado Actual'
                    ],
                    [
                        'attribute' => 'id_tipo_trabajo',
                        'value'     => $model->getDescripcionTipoTrabajo(),
                    ],
                    [
                        'attribute' => 'id_inmueble',
                        'value'     => $model->getDescripcionInmueble(),
                    ],
                ],
            ]) ?>
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
                                'format'    => 'raw'
                            ],
                            'descripcion',
                        ],
                        'pjax'=>true,
                    ]);
                ?>
            </div>
        </div>
        </div>
      </div>
    </div><!-- END BODY TAB -->

  </div><!-- END CARD BODY TAB -->
  
</div><!-- END DIV ordenes-trabajo-view -->