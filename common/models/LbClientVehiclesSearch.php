<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbClientVehicles;

/**
 * LbClientVehiclesSearch represents the model behind the search form of `common\models\LbClientVehicles`.
 */
class LbClientVehiclesSearch extends LbClientVehicles {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'client_id', 'department_id', 'vehicle_type', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['vehicle_number', 'created_at', 'updated_at', 'rfid', 'asset', 'SecondaryTagId'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = LbClientVehicles::find();

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
            'id' => $this->id,
            'client_id' => $this->client_id,
            'department_id' => $this->department_id,
            'vehicle_type' => $this->vehicle_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_by_type' => $this->created_by_type,
            'updated_by_type' => $this->updated_by_type,
            'sort_order' => $this->sort_order,
            'asset' => $this->asset,
            'SecondaryTagId' => $this->SecondaryTagId,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'vehicle_number', $this->vehicle_number]);

        return $dataProvider;
    }

}
