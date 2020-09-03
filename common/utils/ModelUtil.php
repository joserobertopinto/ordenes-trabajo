<?php 
namespace app\common\utils;

use yii\web\HttpException;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * 
 * 
 */

class ModelUtil {
	
	/**
	 * si el atributo tiene varios errores, los pone todos juntos en un solo mensaje
	 * @param unknown $model
	 * @param unknown $atributo
	 */
	public static function unificarErrores($model,$atributo){
		$separa=' -- ';
		if ($model->hasErrors($atributo)){
			$errores = $model->getErrors($atributo);
			$cant = count($errores);
			if ($cant>1){
				$mensaje='';
				foreach ($errores as $i=>$mensajeError) {
					$mensaje.=$mensajeError.
							  (($i+1==$cant)?'':$separa); //separador
				}
				$model->clearErrors($atributo);
				$model->addError($atributo,$mensaje);
			}
			return $model; 
		}
	}
	
	/**
	 * Devuelve un string con los errores, sacandole el atributo asociado
	 *  -Error 1
	 *  -Error 2
	 * @param unknown $model
	 * @return string
	 */
	public static function aplanarErrores($model){
	    $mensaje = '';
	    foreach ($model->getErrors() as $propiedad=>$errores) {
	        foreach ($errores as $error) {
	            $mensaje .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<STRONG>-</STRONG>&nbsp;'.$error.'<BR>';
	        }
	    }
	    return $mensaje;
	}
}
