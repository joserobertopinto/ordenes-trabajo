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
    const ESTADO_BORRADOR           = '578fa5e2-8044-4b62-b4e9-e41821c658cc';   //BORRADOR
    const ESTADO_PENDIENTE          = '9007850e-8a7b-47c5-8747-4ead8ff3e134';	//PENDIENTE
    const ESTADO_EN_PROGRESO        = '45077e45-8a78-4b4d-9abb-c7e6c9fb3d07';	//EN PROGRESO
    const ESTADO_FINALIZADO         = '27ab5c71-a7b4-411b-bba4-4d4a98efcfc0';	//FINALIZADO
    const ESTADO_FINALIZADO_PARCIAL = 'cac4692d-9d34-4509-beb8-f0799c5fb256';	//FINALIZADO_PARCIAL

    public $orden = [0 => self::ESTADO_BORRADOR, 1 => self::ESTADO_PENDIENTE, 2 => self::ESTADO_EN_PROGRESO,  3 => self::ESTADO_FINALIZADO,  4 => self::ESTADO_FINALIZADO_PARCIAL];

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
        }elseif ($this->id_estado == self::ESTADO_FINALIZADO_PARCIAL){
            $color = 'bg-red';
    //             $classAndIcon['icon'] = "fa fa-file-text-o " . $classAndIcon['color'];
        }
        
        return $color;
    }

    /**
    * 
    */
    public function getEstadoProximo() {
        $indiceActual   = array_search($this->id_estado,$this->orden);

        if($indiceActual == array_key_last($this->orden) || ($indiceActual +1) == array_key_last($this->orden))
            $proximo = NULL;
        else 
            $proximo = $indiceActual + 1;
            

        return (is_null($proximo)) ? $proximo : $this->orden[$proximo];
    }

    /**
    * 
    */
    public function getEstadoAnterior() {
        $indiceActual   = array_search($this->id_estado,$this->orden);

        if($indiceActual != array_key_first($this->orden))
            $anterior = $indiceActual - 1;
        else 
            $anterior = NULL;
        
        return (is_null($anterior)) ? $anterior : $this->orden[$anterior];
    }

    public function getEstadoLabel($id_estado) {
        return Estado::findOne($id_estado)->descripcion;
    }

    public static function getEstadoLabelbyId($id_estado) {
        return Estado::findOne($id_estado)->descripcion;
    }
}
