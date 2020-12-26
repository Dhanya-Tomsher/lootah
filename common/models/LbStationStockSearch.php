<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbStationStock;

/**
 * LbStationStockSearch represents the model behind the search form of `common\models\LbStationStock`.
 */
class LbStationStockSearch extends LbStationStock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'day_entry', 'month_entry', 'year_entry', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['opening_stock_litre', 'opening_stock_gallon', 'supplier_purchase_litre', 'supplier_purchase_gallon', 'tanker_load_litre', 'tanker_load_gallon', 'tanker_unload_litre', 'tanker_unload_gallon', 'station_sale_litre', 'station_sale_gallon', 'total_intake_litre', 'total_intake_gallon', 'total_out_litre', 'total_out_gallon', 'stock_in_dispenser_litre', 'stock_in_dispenser_gallon'], 'number'],
            [['date_entry', 'created_at', 'updated_at'], 'safe'],
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
        $query = LbStationStock::find();

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
            'opening_stock_litre' => $this->opening_stock_litre,
            'opening_stock_gallon' => $this->opening_stock_gallon,
            'supplier_purchase_litre' => $this->supplier_purchase_litre,
            'supplier_purchase_gallon' => $this->supplier_purchase_gallon,
            'tanker_load_litre' => $this->tanker_load_litre,
            'tanker_load_gallon' => $this->tanker_load_gallon,
            'tanker_unload_litre' => $this->tanker_unload_litre,
            'tanker_unload_gallon' => $this->tanker_unload_gallon,
            'station_sale_litre' => $this->station_sale_litre,
            'station_sale_gallon' => $this->station_sale_gallon,
            'total_intake_litre' => $this->total_intake_litre,
            'total_intake_gallon' => $this->total_intake_gallon,
            'total_out_litre' => $this->total_out_litre,
            'total_out_gallon' => $this->total_out_gallon,
            'stock_in_dispenser_litre' => $this->stock_in_dispenser_litre,
            'stock_in_dispenser_gallon' => $this->stock_in_dispenser_gallon,
            'date_entry' => $this->date_entry,
            'day_entry' => $this->day_entry,
            'month_entry' => $this->month_entry,
            'year_entry' => $this->year_entry,
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
