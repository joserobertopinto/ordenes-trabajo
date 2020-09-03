<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArchivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Archivos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archivo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Archivo'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_archivo',
            'nombre',
            'descripcion',
            'path',
            'fecha_creacion',
            //'extension',
            //'tamanio',
            //'borrado:boolean',
            //'id_tipo_archivo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
