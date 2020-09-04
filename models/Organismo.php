<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.organismo".
 *
 * @property string $id_organismo
 * @property string $descripcion
 */
class Organismo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.organismo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_organismo', 'descripcion'], 'required'],
            [['id_organismo'], 'string'],
            [['descripcion'], 'string', 'max' => 255],
            [['id_organismo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_organismo' => Yii::t('app', 'Id Organismo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }
}
