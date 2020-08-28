<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordenes_trabajo.archivo".
 *
 * @property string $id_archivo
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $path
 * @property string $fecha_creacion
 * @property string $extension
 * @property int $tamanio
 * @property bool $borrado
 * @property string $id_tipo_archivo
 */
class Archivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.archivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_archivo', 'nombre', 'path', 'fecha_creacion', 'extension', 'tamanio', 'borrado', 'id_tipo_archivo'], 'required'],
            [['id_archivo'], 'string'],
            [['fecha_creacion'], 'safe'],
            [['tamanio'], 'default', 'value' => null],
            [['tamanio'], 'integer'],
            [['borrado'], 'boolean'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion', 'path'], 'string', 'max' => 500],
            [['extension'], 'string', 'max' => 5],
            [['id_tipo_archivo'], 'string', 'max' => 150],
            [['id_archivo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_archivo' => Yii::t('app', 'Id Archivo'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'path' => Yii::t('app', 'Path'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
            'extension' => Yii::t('app', 'Extension'),
            'tamanio' => Yii::t('app', 'Tamanio'),
            'borrado' => Yii::t('app', 'Borrado'),
            'id_tipo_archivo' => Yii::t('app', 'Id Tipo Archivo'),
        ];
    }
}
