<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.ordenes_trabajo_archivo".
 *
 * @property string $id_ordenes_trabajo_archivo
 * @property string $id_ordenes_trabajo
 * @property string $id_archivo
 */
class OrdenesTrabajoArchivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.ordenes_trabajo_archivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ordenes_trabajo_archivo', 'id_ordenes_trabajo', 'id_archivo'], 'required'],
            [['id_ordenes_trabajo_archivo', 'id_ordenes_trabajo', 'id_archivo'], 'string'],
            [['id_ordenes_trabajo_archivo'], 'unique'],
            [['id_archivo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajoArchivo::className(), 'targetAttribute' => ['id_archivo' => 'id_archivo']],
            [['id_ordenes_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajoOrdenesTrabajo::className(), 'targetAttribute' => ['id_ordenes_trabajo' => 'id_ordenes_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ordenes_trabajo_archivo' => Yii::t('app', 'Id Ordenes Trabajo Archivo'),
            'id_ordenes_trabajo' => Yii::t('app', 'Id Ordenes Trabajo'),
            'id_archivo' => Yii::t('app', 'Id Archivo'),
        ];
    }
}
