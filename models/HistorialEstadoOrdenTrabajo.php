<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Estado;
use app\models\OrdenesTrabajo;
use app\models\User;
use app\common\utils\Permiso;

/**
 * This is the model class for table "ordenes_trabajo.historial_estado_orden_trabajo".
 *
 * @property string $id_historial_estado_orden_trabajo
 * @property string $id_estado
 * @property string|null $id_usuario *** id del usuario que realizo el cambio de estado ***
 * @property string $fecha_hora
 * @property string|null $observacion
 * @property string $id_ordenes_trabajo
 */
class HistorialEstadoOrdenTrabajo extends \yii\db\ActiveRecord
{
    public $parcial;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.historial_estado_orden_trabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estado', 'fecha_hora', 'id_ordenes_trabajo'], 'required'],
            [['id_historial_estado_orden_trabajo', 'id_estado', 'id_usuario', 'id_ordenes_trabajo'], 'string'],
            [['fecha_hora','parcial'], 'safe'],
            [['observacion'], 'string', 'max' => 512],
            [['id_historial_estado_orden_trabajo'], 'unique'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_ordenes_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajo::className(), 'targetAttribute' => ['id_ordenes_trabajo' => 'id_ordenes_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_historial_estado_orden_trabajo' => Yii::t('app', 'Id Historial Estado Orden Trabajo'),
            'id_estado' => Yii::t('app', 'Id Estado'),
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'fecha_hora' => Yii::t('app', 'Fecha Hora'),
            'observacion' => Yii::t('app', 'Comentario'),
            'id_ordenes_trabajo' => Yii::t('app', 'Id Ordenes Trabajo'),
            'parcial' => Yii::t('app', 'Parcialmente Finalizada'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id_usuario' => 'id_usuario']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id_estado' => 'id_estado']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrdenesTrabajo()
    {
        return $this->hasOne(OrdenesTrabajo::className(), ['id_ordenes_trabajo' => 'id_ordenes_trabajo']);
    }

    /**
     * Para time-line
     * 
     * */
    public function color() {
        return $this->estado->color();
    }

    /**
     * condiciones para mostrar un el boton de proximo
     * debe tener siguiente estado y debe haber tomado la tarea
     */
    public function showButtonProximo(){
        return ((!is_null($this->estado->getEstadoProximo())) && 
            (   
                $this->ordenesTrabajo->id_usuario_asignado == User::getCurrentUserId() ||
                Permiso::esUsuarioSupervisor()
            )
        );
    }

    /**
     * condiciones para mostrar un el boton de atras
     * debe tener estado anterior y debe haber tomado la tarea
     */
    public function showButtonAnterior(){
        return (
            (!is_null($this->estado->getEstadoAnterior())) && 
            (
                $this->ordenesTrabajo->id_usuario_asignado == User::getCurrentUserId() ||
                Permiso::esUsuarioSupervisor()
            )
        );
    }

    /**
     * Muestra el boton asignar
     * si es usuario operador y no tiene asignada la tarea
     */
    public function showButtonAsignarme(){
        
        $usuariosResponsables = ArrayHelper::map($this->ordenesTrabajo->usuarioOrdenTrabajo, 'id_usuario', 'id_usuario');
        $usuarioActual = User::getCurrentUserId();
        
        return ( 
            Permiso::esUsuarioOperador() && 
            !($this->_estoyAsignado()) &&
            in_array($usuarioActual, $usuariosResponsables)
        );
    }

     /**
     * 
     */
    public function showEditarComentario(){
        $salida = false;
        
        if(  Permiso::esUsuarioSupervisor() || $this->_estoyAsignado() )
            $salida = true;

        return $salida;
    }

    /**
     * 
     */
    public function mostrarEstado(){
        $salida = true;
        
        if($this->id_estado ==  Estado::ESTADO_BORRADOR && $this->ordenesTrabajo->id_usuario_crea != User::getCurrentUserId() )
            $salida = false;

        return $salida;
    }

    private function _estoyAsignado(){
        
        $usuarioActual = User::getCurrentUserId();
        
        return $this->ordenesTrabajo->id_usuario_asignado == $usuarioActual;
    }
}
