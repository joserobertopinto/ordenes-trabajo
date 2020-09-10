<?php

namespace app\models;

use Yii;
use app\models\OrdenesTrabajo;

/**
 * This is the model class for table "ordenes_trabajo.modificaciones_ot".
 *
 * @property string $id_modificacion
 * @property string|null $campos
 * @property string|null $fecha_hora
 * @property string|null $id_ordenes_trabajo
 */
class Modificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.modificaciones_ot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_modificacion', 'descripcion'], 'string'],
            [['fecha_hora'], 'safe'],
            [['id_modificacion'], 'unique'],
            [['id_ordenes_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajo::className(), 'targetAttribute' => ['id_ordenes_trabajo' => 'id_ordenes_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_modificacion' => Yii::t('app', 'Id Modificacion'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'fecha_hora' => Yii::t('app', 'Fecha Hora'),
            'id_ordenes_trabajo' => Yii::t('app', 'Id Ordenes Trabajo'),
        ];
    }
}
