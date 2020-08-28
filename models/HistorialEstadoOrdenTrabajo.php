<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.historial_estado_orden_trabajo".
 *
 * @property string $id_historial_estado_orden_trabajo
 * @property string $id_estado
 * @property string|null $id_usuario
 * @property string $fecha_hora
 * @property string|null $observacion
 * @property string $id_ordenes_trabajo
 */
class HistorialEstadoOrdenTrabajo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.historial_estado_orden_trabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_historial_estado_orden_trabajo', 'id_estado', 'fecha_hora', 'id_ordenes_trabajo'], 'required'],
            [['id_historial_estado_orden_trabajo', 'id_estado', 'id_usuario', 'id_ordenes_trabajo'], 'string'],
            [['fecha_hora'], 'safe'],
            [['observacion'], 'string', 'max' => 512],
            [['id_historial_estado_orden_trabajo'], 'unique'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajoEstado::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_ordenes_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajoOrdenesTrabajo::className(), 'targetAttribute' => ['id_ordenes_trabajo' => 'id_ordenes_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_historial_estado_orden_trabajo' => Yii::t('app', 'Id Historial Estado Orden Trabajo'),
            'id_estado' => Yii::t('app', 'Id Estado'),
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'fecha_hora' => Yii::t('app', 'Fecha Hora'),
            'observacion' => Yii::t('app', 'Observacion'),
            'id_ordenes_trabajo' => Yii::t('app', 'Id Ordenes Trabajo'),
        ];
    }
}
