<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.inmueble".
 *
 * @property string $id_inmueble
 * @property string|null $descripcion
 */
class Inmueble extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.inmueble';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_inmueble'], 'required'],
            [['id_inmueble'], 'string'],
            [['descripcion'], 'string', 'max' => 255],
            [['id_inmueble'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_inmueble' => Yii::t('app', 'Id Inmueble'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }
}
