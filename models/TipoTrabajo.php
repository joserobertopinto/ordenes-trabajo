<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.tipo_trabajo".
 *
 * @property string $id_tipo_trabajo
 * @property string|null $descripcion
 */
class TipoTrabajo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.tipo_trabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_trabajo'], 'required'],
            [['id_tipo_trabajo'], 'string'],
            [['descripcion'], 'string', 'max' => 255],
            [['id_tipo_trabajo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_trabajo' => Yii::t('app', 'Id Tipo Trabajo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }
}
