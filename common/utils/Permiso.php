<?php
namespace app\common\utils;

class Permiso {
    
    const ROL_SUPERVISOR    = 'R_SUPERVISOR';
    const ROL_OPERADOR      = 'R_OPERADOR';
    
    public static function esUsuarioSupervisor() {
        return \Yii::$app->user->can(self::ROL_SUPERVISOR);
    }
    
    public static function esPerito(){
        return \Yii::$app->user->can(self::PERMISO_PERITO);
    }
    
}
