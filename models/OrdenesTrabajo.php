<?php

namespace app\models;

use Yii;
use app\models\Archivo;
use app\common\utils\ModelUtil;

/**
 * This is the model class for table "ordenes_trabajo.ordenes_trabajo".
 *
 * @property string $id_ordenes_trabajo
 * @property string $nro_orden_trabajo
 * @property string|null $fecha_hora_creacion
 * @property string|null $fecha_hora_finalizacion
 * @property string $descripcion
 * @property string|null $id_historial_estado_orden_trabajo
 * @property string $id_tipo_trabajo
 * @property string $id_inmueble
 */
class OrdenesTrabajo extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE   = 'scenario_create';
    const SCENARIO_UPDATE   = 'scenario_update';

    /**
     * {@inheritdoc}
     */
    
    //variables para el form
    public $fecha_finalizacion, $hora_finalizacion;

    public $archivo;

    public static function tableName()
    {
        return 'ordenes_trabajo.ordenes_trabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_finalizacion','hora_finalizacion','titulo', 'descripcion', 'id_tipo_trabajo', 'id_inmueble'], 'required', 'on' =>[self::SCENARIO_UPDATE]],
            [['titulo', 'descripcion', 'id_tipo_trabajo', 'id_inmueble','nro_orden_trabajo'], 'safe', 'on' =>[self::SCENARIO_CREATE]],
            [['descripcion', 'id_historial_estado_orden_trabajo', 'id_tipo_trabajo', 'id_inmueble'], 'string'],
            [['fecha_hora_creacion', 'fecha_hora_finalizacion'], 'safe'],
            [['nro_orden_trabajo'], 'string', 'max' => 50],
            [['nro_orden_trabajo'], 'string', 'max' => 100],
            [['id_ordenes_trabajo'], 'unique'],
            [['id_historial_estado_orden_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => HistorialEstadoOrdenTrabajo::className(), 'targetAttribute' => ['id_historial_estado_orden_trabajo' => 'id_historial_estado_orden_trabajo']],
            [['id_inmueble'], 'exist', 'skipOnError' => true, 'targetClass' => Inmueble::className(), 'targetAttribute' => ['id_inmueble' => 'id_inmueble']],
            [['id_tipo_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTrabajo::className(), 'targetAttribute' => ['id_tipo_trabajo' => 'id_tipo_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ordenes_trabajo' => Yii::t('app', 'Id Ordenes Trabajo'),
            'nro_orden_trabajo' => Yii::t('app', 'Nro. Orden Trabajo'),
            'fecha_hora_creacion' => Yii::t('app', 'Fecha y Hora de Creación'),
            'fecha_hora_finalizacion' => Yii::t('app', 'Fecha y Hora de Finalización'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'id_historial_estado_orden_trabajo' => Yii::t('app', 'Historial de Estados'),
            'id_tipo_trabajo' => Yii::t('app', 'Tipo Trabajo'),
            'id_inmueble' => Yii::t('app', 'Inmueble'),
            'titulo' => Yii::t('app', 'Título'),
            'fecha_finalizacion' => Yii::t('app', 'Fecha de Finalización'),
            'hora_finalizacion' => Yii::t('app', 'Hora de Finalización'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getArchivos()
    {
        return $this->hasMany(Archivo::className(), ['id_ordenes_trabajo' => 'id_ordenes_trabajo']);
    }

    /**
     * crea nuevo estado y asocia a orden de trabajo
     * Empty($error), si no hay error
     */
    public function pasarEstado($id_estado){
        $error = '';
        $historialOrden = new HistorialEstadoOrdenTrabajo;
        $historialOrden->id_estado = $id_estado;
        // $historialOrden->id_usuario = $id_usuario; //ver id_persona
        $historialOrden->fecha_hora = Date('Y-m-d H:i:s');
        $historialOrden->id_ordenes_trabajo = $this->id_ordenes_trabajo;

        if (!$historialOrden->save())
            $error = 'No se pudo guardar el nuevo Historial.<BR>'.ModelUtil::aplanarErrores($historialOrden);
        
        if (empty($error)){
            $this->id_historial_estado_orden_trabajo = $historialOrden->id_historial_estado_orden_trabajo;
            if (!$this->save())
                $error = 'No se pudo actualizar el Historial de la Orden.<BR>'.ModelUtil::aplanarErrores($this);
        }

        return $error;
    }
}