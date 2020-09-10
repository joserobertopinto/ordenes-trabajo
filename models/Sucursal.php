<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.sucursal".
 *
 * @property string $id_sucursal
 * @property string $descripcion
 */
class Sucursal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.sucursal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal', 'descripcion'], 'required'],
            [['id_sucursal'], 'string'],
            [['descripcion'], 'string', 'max' => 255],
            [['id_sucursal'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_sucursal' => Yii::t('app', 'Id Sucursal'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }
}
