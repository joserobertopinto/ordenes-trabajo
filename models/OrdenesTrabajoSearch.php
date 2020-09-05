<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrdenesTrabajo;

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
            [['id_ordenes_trabajo', 'nro_orden_trabajo', 'fecha_hora_creacion', 'fecha_hora_finalizacion', 'descripcion', 'id_historial_estado_orden_trabajo', 'id_tipo_trabajo', 'id_inmueble','titulo'], 'safe'],
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
        $query = OrdenesTrabajo::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'fecha_hora_creacion' => $this->fecha_hora_creacion,
            'fecha_hora_finalizacion' => $this->fecha_hora_finalizacion,
        ]);

        $query->andFilterWhere(['ilike', 'id_ordenes_trabajo', $this->id_ordenes_trabajo])
            ->andFilterWhere(['ilike', 'nro_orden_trabajo', $this->nro_orden_trabajo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'id_historial_estado_orden_trabajo', $this->id_historial_estado_orden_trabajo])
            ->andFilterWhere(['ilike', 'id_tipo_trabajo', $this->id_tipo_trabajo])
            ->andFilterWhere(['ilike', 'id_inmueble', $this->id_inmueble]);

        return $dataProvider;
    }
}
