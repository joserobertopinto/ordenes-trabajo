<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Archivo;

/**
 * ArchivoSearch represents the model behind the search form of `app\models\Archivo`.
 */
class ArchivoSearch extends Archivo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_archivo', 'nombre', 'descripcion', 'path', 'fecha_creacion', 'extension', 'id_ordenes_trabajo' ], 'safe'],
            [['tamanio'], 'integer'],
            [['borrado'], 'boolean'],
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
        $query = Archivo::find();

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
            'fecha_creacion' => $this->fecha_creacion,
            'tamanio' => $this->tamanio,
            'borrado' => $this->borrado,
        ]);

        $query
            ->andFilterWhere(['=', 'id_archivo', $this->id_archivo])
            ->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'path', $this->path])
            ->andFilterWhere(['ilike', 'extension', $this->extension])
            ->andFilterWhere(['=', 'id_ordenes_trabajo', $this->id_ordenes_trabajo]);

        return $dataProvider;
    }
}
