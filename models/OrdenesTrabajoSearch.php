<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrdenesTrabajo;
use app\common\utils\Permiso;
use app\common\utils\Fecha;

/**
 * OrdenesTrabajoSearch represents the model behind the search form of `app\models\OrdenesTrabajo`.
 */
class OrdenesTrabajoSearch extends OrdenesTrabajo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operadores','id_ordenes_trabajo', 'nro_orden_trabajo', 'fecha_hora_creacion', 'fecha_hora_finalizacion', 'descripcion', 'id_tipo_trabajo', 'id_inmueble','titulo','estadoActual','fecha_hora_comienzo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OrdenesTrabajo::find()->joinWith(['ultimoEstadoOrdenTrabajo', 'usuarioOrdenTrabajo']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'id_ordenes_trabajo', $this->id_ordenes_trabajo])
            ->andFilterWhere(['ilike', 'nro_orden_trabajo', $this->nro_orden_trabajo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['=', 'id_tipo_trabajo', $this->id_tipo_trabajo])
            ->andFilterWhere(['=', 'id_inmueble', $this->id_inmueble]);

        if(!empty($this->operadores))
            $query->andWhere(['IN', 'usuario_orden_trabajo.id_usuario', $this->operadores]);

        if(!empty($this->estadoActual))
            $query->andWhere(['=', 'historial_estado_orden_trabajo.id_estado', $this->estadoActual]);
    
        /*-------------------------RANGO DE FECHAS INICIO-----------------*/
        if (!empty($this->fecha_hora_comienzo) && strpos($this->fecha_hora_comienzo, ' - ') !== false) {
            
            list($start_date, $end_date) = explode(' - ', $this->fecha_hora_comienzo);
            $start_date = Fecha::convertir($start_date);
            $end_date   = Fecha::convertir($end_date);

            $query->andFilterWhere(['between', 'fecha_hora_comienzo', $start_date, $end_date]);
        }
        /*------------------------------------------------------------------*/

        /**
         * agrego filtro operador
         */
        if(Permiso::esUsuarioOperador())
            $query->andWhere(['=', 'usuario_orden_trabajo.id_usuario', \Yii::$app->user->getId()]);

        /**
         * el estado borrador no lo ve por nadie
         */
        $query->andWhere(['!=', 'historial_estado_orden_trabajo.id_estado', Estado::ESTADO_BORRADOR]);
        
        return $dataProvider;
    }
}
