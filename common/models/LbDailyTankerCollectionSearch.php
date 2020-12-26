<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbDailyTankerCollection;

/**
 * LbDailyTankerCollectionSearch represents the model behind the search form of `common\models\LbDailyTankerCollection`.
 */
class LbDailyTankerCollectionSearch extends LbDailyTankerCollection
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tanker_id', 'operator_id', 'client_type', 'vehicle_id', 'collection_type', 'supervisor_approval_status', 'supervisor_approved_by', 'area_manager_approval_status', 'area_manager_approved_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['quantity_gallon', 'quantity_litre', 'amount'], 'number'],
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
        $query = LbDailyTankerCollection::find();

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
            'tanker_id' => $this->tanker_id,
            'operator_id' => $this->operator_id,
            'client_type' => $this->client_type,
            'vehicle_id' => $this->vehicle_id,
            'collection_type' => $this->collection_type,
            'quantity_gallon' => $this->quantity_gallon,
            'quantity_litre' => $this->quantity_litre,
            'amount' => $this->amount,
            'supervisor_approval_status' => $this->supervisor_approval_status,
            'supervisor_approved_by' => $this->supervisor_approved_by,
            'area_manager_approval_status' => $this->area_manager_approval_status,
            'area_manager_approved_by' => $this->area_manager_approved_by,
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
