<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\Organismo;
/**
 * This is the model class for table "ordenes_trabajo.persona".
 *
 * @property string $id_persona
 * @property string|null $apellido
 * @property string|null $nombre
 * @property string|null $id_organismo
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_persona'], 'required'],
            [['id_persona', 'id_organismo'], 'string'],
            [['apellido', 'nombre'], 'string', 'max' => 255],
            [['id_persona'], 'unique'],
            [['id_organismo'], 'exist', 'skipOnError' => true, 'targetClass' => Organismo::className(), 'targetAttribute' => ['id_organismo' => 'id_organismo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_persona' => Yii::t('app', 'Id Persona'),
            'apellido' => Yii::t('app', 'Apellido'),
            'nombre' => Yii::t('app', 'Nombre'),
            'id_organismo' => Yii::t('app', 'Id Organismo'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    	return $this->hasOne(User::className(), ['id_persona' => 'id_persona']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrganismo()
    {
    	return $this->hasOne(Organismo::className(), ['id_organismo' => 'id_organismo']);
    }

}
