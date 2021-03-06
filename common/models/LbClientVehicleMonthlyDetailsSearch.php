<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbClientVehicleMonthlyDetails;

/**
 * LbClientVehicleMonthlyDetailsSearch represents the model behind the search form of `common\models\LbClientVehicleMonthlyDetails`.
 */
class LbClientVehicleMonthlyDetailsSearch extends LbClientVehicleMonthlyDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'vehicle_id', 'month', 'year', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['total_purchase_litre'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = LbClientVehicleMonthlyDetails::find();

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
            'vehicle_id' => $this->vehicle_id,
            'total_purchase_litre' => $this->total_purchase_litre,
            'month' => $this->month,
            'year' => $this->year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_by_type' => $this->created_by_type,
            'updated_by_type' => $this->updated_by_type,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
