<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.estado".
 *
 * @property string $id_estado
 * @property string $descripcion
 */
class Estado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.estado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estado', 'descripcion'], 'required'],
            [['id_estado'], 'string'],
            [['descripcion'], 'string', 'max' => 255],
            [['id_estado'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_estado' => Yii::t('app', 'Id Estado'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }
}
