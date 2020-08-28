<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.tipo_relacion".
 *
 * @property string $id_tipo_relacion
 * @property string $descripcion
 */
class TipoRelacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.tipo_relacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_relacion', 'descripcion'], 'required'],
            [['id_tipo_relacion'], 'string'],
            [['descripcion'], 'string', 'max' => 255],
            [['id_tipo_relacion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_relacion' => Yii::t('app', 'Id Tipo Relacion'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }
}
