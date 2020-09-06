<?php

namespace app\models;

use Yii;
use app\models\Archivo;
use app\common\utils\ModelUtil;
use app\common\utils\Fecha;
use app\models\OrdenAnioNro;
use app\models\UsuarioOrdenTrabajo;
use app\models\TipoTrabajo;
use app\models\Inmueble;

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
    public $fecha_finalizacion, $hora_finalizacion, $fecha_comienzo, $hora_comienzo, $archivo;

    public $listaOperadores = [];

    public $listaOperadoresTexts;

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
            [['fecha_comienzo','hora_comienzo','titulo', 'descripcion', 'id_tipo_trabajo', 'id_inmueble'], 'required', 'on' =>[self::SCENARIO_UPDATE]],
            [['titulo', 'descripcion', 'id_tipo_trabajo', 'id_inmueble','nro_orden_trabajo'], 'safe', 'on' =>[self::SCENARIO_CREATE]],
            [['fecha_hora_creacion','id_usuario_crea'], 'required', 'on' =>[self::SCENARIO_CREATE]],
            [['descripcion', 'id_historial_estado_orden_trabajo', 'id_tipo_trabajo', 'id_inmueble'], 'string'],
            [['fecha_hora_creacion', 'fecha_hora_finalizacion','listaOperadores'], 'safe'],
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
            'fecha_comienzo' => Yii::t('app', 'Fecha de Comienzo'),
            'hora_comienzo' => Yii::t('app', 'Hora de Comienzo'),
            'listaOperadores'  => Yii::t('app','Operadores asignados a la tarea'),
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
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarioOrdenTrabajo()
    {
        return $this->hasMany(UsuarioOrdenTrabajo::className(), ['id_ordenes_trabajo' => 'id_ordenes_trabajo']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUltimoEstadoOrdenTrabajo()
    {
        return $this->hasOne(HistorialEstadoOrdenTrabajo::className(), ['id_historial_estado_orden_trabajo' => 'id_historial_estado_orden_trabajo']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getHistorialEstadoOrdenTrabajo()
    {
        return $this->hasMany(HistorialEstadoOrdenTrabajo::className(), ['id_ordenes_trabajo' => 'id_ordenes_trabajo'])->orderBy(['fecha_hora'=>SORT_DESC]);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTipoTrabajo()
    {
        return $this->hasOne(TipoTrabajo::className(), ['id_tipo_trabajo' => 'id_tipo_trabajo']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getInmueble()
    {
        return $this->hasOne(Inmueble::className(), ['id_inmueble' => 'id_inmueble']);
    }

    /**
     * crea nuevo estado y asocia a orden de trabajo
     * Empty($error), si no hay error
     */
    public function pasarEstado($id_estado){
        $error = '';
        $historialOrden = new HistorialEstadoOrdenTrabajo;
        $historialOrden->id_estado = $id_estado;
        $historialOrden->id_usuario = Yii::$app->user->identity->id_usuario;
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

    /**
     * seteo nro de orden con bloqueo
     */
    public function setNumeroOrden(){
        
        if(is_null($this->nro_orden_trabajo)){
            
            $anio  = substr(Fecha::fechaHoy(), 0, 4);

            $numeroOrden = OrdenAnioNro::getProximoNumero($anio);
            
            $this->nro_orden_trabajo =  $anio.'-'.str_pad($numeroOrden, 5, "0", STR_PAD_LEFT);

        }
    }

    /**
     * cargo id con text de operadores al modelo
     */
    public function loadOperadores(){
        if (!empty($this->usuarioOrdenTrabajo)){
            foreach ($this->usuarioOrdenTrabajo as $usuarioOrden) {
                
                $this->listaOperadores[] = $usuarioOrden->id_usuario;

                $persona = $usuarioOrden->usuario->persona;
                
                $this->listaOperadoresTexts[]  = $persona->apellido . ', ' . $persona->nombre .' (' . $persona->organismo->descripcion . ')';
            }
        }
    }

    /**
     * cargo id con text de operadores al modelo
     */
    public function loadFechaFinalizacion(){
        if(isset($this->fecha_hora_finalizacion)){
            $fecha_hora = explode(' ',$this->fecha_hora_finalizacion);
            $this->fecha_finalizacion = $fecha_hora[0];
            $this->hora_finalizacion = $fecha_hora[1];
        }
    }

    /**
     * cargo id con text de operadores al modelo
     */
    public function loadFechaComienzo(){
        if(isset($this->fecha_hora_comienzo)){
            $fecha_hora = explode(' ',$this->fecha_hora_comienzo);
            $this->fecha_comienzo = $fecha_hora[0];
            $this->hora_comienzo = $fecha_hora[1];
        }
    }

    /**
     * descripcion por relacion de tipo de trabajo 
     */
    public function getDescripcionUltimoEstado(){
        return $this->ultimoEstadoOrdenTrabajo->estado->descripcion;
    }

    /**
     * descripcion por relacion de tipo de trabajo
     */
    public function getDescripcionTipoTrabajo(){
        return $this->tipoTrabajo->descripcion;
    }

    /**
     * descripcion por relacion de tipo de trabajo
     */
    public function getDescripcionInmueble(){
        return $this->inmueble->descripcion;
    }

    /**
     * descripcion por relacion de tipo de trabajo 
     */
    public function getLabelUltimoEstado(){
        return '<span>' . $this->getDescripcionUltimoEstado . '</span>';
    }

    /**
     * descripcion por relacion de tipo de trabajo
     */
    public function getLabelTipoTrabajo(){
        return '<span>' . $this->getDescripcionTipoTrabajo . '</span>';
    }

    /**
     * descripcion por relacion de tipo de trabajo
     */
    public function getLabelInmueble(){
        return '<span>' . $this->getDescripcionInmueble . '</span>';
    }
}