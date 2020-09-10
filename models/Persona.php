<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\Sucursal;
/**
 * This is the model class for table "ordenes_trabajo.persona".
 *
 * @property string $id_persona
 * @property string|null $apellido
 * @property string|null $nombre
 * @property string|null $id_sucursal
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
            [['id_persona', 'id_sucursal'], 'string'],
            [['apellido', 'nombre'], 'string', 'max' => 255],
            [['id_persona'], 'unique'],
            [['id_sucursal'], 'exist', 'skipOnError' => true, 'targetClass' => Sucursal::className(), 'targetAttribute' => ['id_sucursal' => 'id_sucursal']],
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
            'id_sucursal' => Yii::t('app', 'Id Sucursal'),
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
    public function getSucursal()
    {
    	return $this->hasOne(Sucursal::className(), ['id_sucursal' => 'id_sucursal']);
    }

    /**
     * apellido nombre concatenado
     */
    public function getApellidoNombre(){
        return $this->apellido.', '.$this->nombre;
    }
}
