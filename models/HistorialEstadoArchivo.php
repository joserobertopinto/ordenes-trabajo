<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.historial_estado_archivo".
 *
 * @property string $id_historial_estado_archivo
 * @property string $id_historial_estado_orden_trabajo
 * @property string $id_archivo
 */
class HistorialEstadoArchivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.historial_estado_archivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_historial_estado_archivo', 'id_historial_estado_orden_trabajo', 'id_archivo'], 'required'],
            [['id_historial_estado_archivo', 'id_historial_estado_orden_trabajo', 'id_archivo'], 'string'],
            [['id_historial_estado_archivo'], 'unique'],
            [['id_archivo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajoArchivo::className(), 'targetAttribute' => ['id_archivo' => 'id_archivo']],
            [['id_historial_estado_orden_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajoHistorialEstadoOrdenTrabajo::className(), 'targetAttribute' => ['id_historial_estado_orden_trabajo' => 'id_historial_estado_orden_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_historial_estado_archivo' => Yii::t('app', 'Id Historial Estado Archivo'),
            'id_historial_estado_orden_trabajo' => Yii::t('app', 'Id Historial Estado Orden Trabajo'),
            'id_archivo' => Yii::t('app', 'Id Archivo'),
        ];
    }
}
