<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbDailyStationCollection;

/**
 * LbDailyStationCollectionSearch represents the model behind the search form of `common\models\LbDailyStationCollection`.
 */
class LbDailyStationCollectionSearch extends LbDailyStationCollection
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'operator_id', 'nozzle', 'client_type', 'client_id', 'vehicle_id', 'vehicle_number', 'odometer_reading', 'collection_type', 'edited_by', 'edit_approval_status', 'edit_approved_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status', 'supervisor_verification_status', 'supervisor_verified_by', 'area_manager_verification_status', 'area_manager_verified_by'], 'integer'],
            [['quantity_gallon', 'quantity_litre', 'amount', 'opening_stock', 'closing_stock'], 'number'],
            [['description_for_edit', 'edit_approval_comments', 'created_at', 'updated_at'], 'safe'],
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
        $query = LbDailyStationCollection::find();

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
            'station_id' => $this->station_id,
            'operator_id' => $this->operator_id,
            'nozzle' => $this->nozzle,
            'client_type' => $this->client_type,
            'client_id' => $this->client_id,
            'vehicle_id' => $this->vehicle_id,
            'vehicle_number' => $this->vehicle_number,
            'odometer_reading' => $this->odometer_reading,
            'collection_type' => $this->collection_type,
            'quantity_gallon' => $this->quantity_gallon,
            'quantity_litre' => $this->quantity_litre,
            'amount' => $this->amount,
            'opening_stock' => $this->opening_stock,
            'closing_stock' => $this->closing_stock,
            'edited_by' => $this->edited_by,
            'edit_approval_status' => $this->edit_approval_status,
            'edit_approved_by' => $this->edit_approved_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_by_type' => $this->created_by_type,
            'updated_by_type' => $this->updated_by_type,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'supervisor_verification_status' => $this->supervisor_verification_status,
            'supervisor_verified_by' => $this->supervisor_verified_by,
            'area_manager_verification_status' => $this->area_manager_verification_status,
            'area_manager_verified_by' => $this->area_manager_verified_by,
        ]);

        $query->andFilterWhere(['like', 'description_for_edit', $this->description_for_edit])
            ->andFilterWhere(['like', 'edit_approval_comments', $this->edit_approval_comments]);

        return $dataProvider;
    }
}
