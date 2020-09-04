<?php

namespace app\models;

use Yii;
use app\common\utils\Fecha;
use app\common\utils\ModelUtil;

/**
 * This is the model class for table "ordenes_trabajo.orden_anio_nro".
 *
 * @property string $id_orden_anio_nro
 * @property integer $anio
 * @property integer $numero
 */
class OrdenAnioNro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.orden_anio_nro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['anio', 'numero'], 'required'],
            [['id_orden_anio_nro'], 'string'],
            [['anio', 'numero'], 'default', 'value' => null],
            [['anio', 'numero'], 'integer'],
            [['id_orden_anio_nro'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_orden_anio_nro' => Yii::t('app', 'Id Orden Anio Nro'),
            'anio' => Yii::t('app', 'Año'),
            'numero' => Yii::t('app', 'Número'),
        ];
    }
    
    /**
     * Devuelve el siguiente nro. secuencial para el campo $propiedadNumero especificado.
     * Por defecto siempre retorna el siquiente nro para el numero de legajo (la propiedad 'numero' del modelo)
     * @param string $anio
     * @throws \Exception
     */
    public static function getProximoNumero($anio) {
        
        $model = self::find()->where(['anio' => $anio])->one();

        // Si no existe el registro lo insertamos.
        // Si al intentar insertar, nos da error, verificamos nuevamente, que otro usuario haya ingresado el registro.
        if (empty($model)) {
            $model = new OrdenAnioNro();
            $model->anio   = $anio;
            $model->numero = 0; 
            
            if (!$model->save()) {
                throw new \Exception('No se pudo guardar el Orden Año Número: '.ModelUtil::aplanarErrores($model));
            } 
        }
        
        //timeout de X milisegundos para select for update
        $timeOut = \Yii::$app->params['lock_timeout'];
            
        \Yii::$app->db->createCommand('SET lock_timeout = '.$timeOut)->execute();
            
        $tabla = self::tableName();
            
        // Loquea el registro para actualizar, ante una eventual concurrencia.
        $ordenAnioNumero = self::findBySql("SELECT * FROM $tabla where anio = :anio FOR UPDATE", [':anio' => $anio])->one();
 
        $ordenAnioNumero->numero += 1;
                
        if (!$ordenAnioNumero->save()) {
            throw new \Exception('Error al actualizar el número de Orden para el año '.$anio.'. '.ModelUtil::aplanarErrores($ordenAnioNumero));
        }
        
        return $ordenAnioNumero->numero;
        
    }
}