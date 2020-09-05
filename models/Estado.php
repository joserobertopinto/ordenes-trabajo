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
    const ESTADO_BORRADOR       = '578fa5e2-8044-4b62-b4e9-e41821c658cc';   //BORRADOR
    const ESTADO_PENDIENTE      = '9007850e-8a7b-47c5-8747-4ead8ff3e134';	//PENDIENTE
    const ESTADO_EN_PROGRESO    = '45077e45-8a78-4b4d-9abb-c7e6c9fb3d07';	//EN PROGRESO
    const ESTADO_FINALIZADO     = '27ab5c71-a7b4-411b-bba4-4d4a98efcfc0';	//FINALIZADO

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

    /**
     * color para cada estado
     */
    public function color() {
       
        if ($this->id_estado == self::ESTADO_BORRADOR){
            $color = 'bg-blue';
//             $classAndIcon["icon"] = "fa fa-balance-scale " . $classAndIcon['color'];
        }
        elseif ($this->id_estado == self::ESTADO_PENDIENTE){
            $color = 'bg-purple';
//             $classAndIcon["icon"] = "fa fa-check-square-o " . $classAndIcon['color'];
        }elseif ($this->id_estado == self::ESTADO_EN_PROGRESO){
            $color = 'bg-aqua';
//             $classAndIcon['icon'] = "fa fa-file-text-o " . $classAndIcon['color'];
        }elseif ($this->id_estado == self::ESTADO_FINALIZADO){
            $color = 'bg-red';
//             $classAndIcon['icon'] = "fa fa-file-text-o " . $classAndIcon['color'];
        }
        
        return $color;
    }
}
