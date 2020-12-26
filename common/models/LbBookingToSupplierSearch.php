<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbBookingToSupplier;

/**
 * LbBookingToSupplierSearch represents the model behind the search form of `common\models\LbBookingToSupplier`.
 */
class LbBookingToSupplierSearch extends LbBookingToSupplier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['booked_quantity_gallon', 'booked_quantity_litre', 'previous_balance_gallon', 'previous_balance_litre', 'current_balance_gallon', 'current_balance_litre', 'price_per_gallon', 'price_per_litre'], 'number'],
            [['booking_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = LbBookingToSupplier::find();

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
            'supplier_id' => $this->supplier_id,
            'booked_quantity_gallon' => $this->booked_quantity_gallon,
            'booked_quantity_litre' => $this->booked_quantity_litre,
            'previous_balance_gallon' => $this->previous_balance_gallon,
            'previous_balance_litre' => $this->previous_balance_litre,
            'current_balance_gallon' => $this->current_balance_gallon,
            'current_balance_litre' => $this->current_balance_litre,
            'booking_date' => $this->booking_date,
            'price_per_gallon' => $this->price_per_gallon,
            'price_per_litre' => $this->price_per_litre,
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
