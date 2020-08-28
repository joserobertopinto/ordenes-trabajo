<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.ordenes_trabajo".
 *
 * @property string $id_ordenes_trabajo
 * @property string $nro_orden_trabajo
 * @property string|null $fecha_hora_creacion
 * @property string|null $fecha_hora_finalizacion
 * @property string $descripcion
 * @property string|null $id_historial_estado_orden_trabajo
 * @property string $id_tipo_trabajo
 * @property string $id_inmueble
 */
class OrdenesTrabajo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    //variables para el form
    public $fecha_finalizacion, $hora_finalizacion;

    public static function tableName()
    {
        return 'ordenes_trabajo.ordenes_trabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'id_tipo_trabajo', 'id_inmueble'], 'required'],
            [['id_ordenes_trabajo', 'descripcion', 'id_historial_estado_orden_trabajo', 'id_tipo_trabajo', 'id_inmueble'], 'string'],
            [['fecha_hora_creacion', 'fecha_hora_finalizacion'], 'safe'],
            [['nro_orden_trabajo'], 'string', 'max' => 50],
            [['nro_orden_trabajo'], 'string', 'max' => 100],
            [['id_ordenes_trabajo'], 'unique'],
            [['id_historial_estado_orden_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => HistorialEstadoOrdenTrabajo::className(), 'targetAttribute' => ['id_historial_estado_orden_trabajo' => 'id_historial_estado_orden_trabajo']],
            [['id_inmueble'], 'exist', 'skipOnError' => true, 'targetClass' => Inmueble::className(), 'targetAttribute' => ['id_inmueble' => 'id_inmueble']],
            [['id_tipo_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTrabajo::className(), 'targetAttribute' => ['id_tipo_trabajo' => 'id_tipo_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ordenes_trabajo' => Yii::t('app', 'Id Ordenes Trabajo'),
            'nro_orden_trabajo' => Yii::t('app', 'Nro. Orden Trabajo'),
            'fecha_hora_creacion' => Yii::t('app', 'Fecha y Hora de Creación'),
            'fecha_hora_finalizacion' => Yii::t('app', 'Fecha y Hora de Finalización'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'id_historial_estado_orden_trabajo' => Yii::t('app', 'Historial de Estados'),
            'id_tipo_trabajo' => Yii::t('app', 'Tipo Trabajo'),
            'id_inmueble' => Yii::t('app', 'Inmueble'),
            'titulo' => Yii::t('app', 'Título'),
            'fecha_finalizacion' => Yii::t('app', 'Fecha de Finalización'),
            'hora_finalizacion' => Yii::t('app', 'Hora de Finalización'),
        ];
    }
}