<?php
namespace app\common\utils;

class Permiso {
    
    const ROL_SUPERVISOR        = 'R_SUPERVISOR';
    const ROL_OPERADOR          = 'R_OPERADOR';
    const PERMISO_SUPERVISOR    = 'P_SUPERVISOR';
    const PERMISO_OPERADOR      = 'P_OPERADOR';
    const PERMISO_EDITAR_ORDEN  = 'P_EDITAR_ORDEN';
    
    public static function esUsuarioSupervisor() {
        return \Yii::$app->user->can(self::PERMISO_SUPERVISOR);
    }
    
    public static function esUsuarioOperador(){
        return \Yii::$app->user->can(self::PERMISO_OPERADOR);
    }

    public static function puedeEditarOrden(){
        return \Yii::$app->user->can(self::PERMISO_EDITAR_ORDEN);
    }
    
}
