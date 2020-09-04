<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "ordenes_trabajo.usuario_orden_trabajo".
 *
 * @property string $id_usuario_orden_trabajo
 * @property string $id_usuario
 * @property string $id_ordenes_trabajo
 */
class UsuarioOrdenTrabajo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.usuario_orden_trabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_ordenes_trabajo'], 'required'],
            [['id_usuario_orden_trabajo', 'id_usuario', 'id_ordenes_trabajo'], 'string'],
            [['id_usuario_orden_trabajo'], 'unique'],
            [['id_ordenes_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajo::className(), 'targetAttribute' => ['id_ordenes_trabajo' => 'id_ordenes_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_orden_trabajo' => Yii::t('app', 'Id Usuario Orden Trabajo'),
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'id_ordenes_trabajo' => Yii::t('app', 'Id Ordenes Trabajo'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id_usuario' => 'id_usuario']);
    }

}
