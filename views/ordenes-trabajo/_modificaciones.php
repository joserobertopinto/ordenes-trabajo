<?php

use app\common\utils\Fecha;
use kartik\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
?>

<div class="card">
<div class="card-body">
    <?=
        GridView::widget([
            'dataProvider'=> $dataProviderModificaciones,
            'filterModel' => false,
            'summary' => '',
            'striped' => false,
            'bordered'=>false,
            'columns' => [
                // [
                //     'attribute' => 'nombre',
                //     'value'     => function($model){return $model->getDescargaHtmlLink();},
                //     'format'    => 'raw'
                // ],
                [
                    'attribute' => 'id_moficacion',
                    'visible'     => false
                ],
                [
                    'attribute' => 'fecha_hora',
                    'label'     => 'Fecha de Modificacón',
                    'value'     => function($model){ return Fecha::convertir($model->fecha_hora);}
                ],
                'descripcion'
            ],
            // 'pjax'=>true,
        ]);
    ?>
</div>
</div>