<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbTankerDailyDataForVerification;

/**
 * LbTankerDailyDataForVerificationSearch represents the model behind the search form of `common\models\LbTankerDailyDataForVerification`.
 */
class LbTankerDailyDataForVerificationSearch extends LbTankerDailyDataForVerification
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tanker_id', 'unit', 'physica_data_entered_by', 'closing_stock_litre', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['date_entry', 'physical_stock', 'stock_by_calculation', 'stock_difference', 'closing_stock', 'created_at', 'updated_at'], 'safe'],
            [['physical_stock_gallon', 'stock_by_calculation_gallon', 'physical_stock_litre', 'stock_by_calculation_litre', 'stock_difference_gallon', 'stock_difference_litre', 'closing_stock_gallon', 'sold_qty', 'cash_sales', 'card_sales'], 'number'],
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
        $query = LbTankerDailyDataForVerification::find();

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
            'date_entry' => $this->date_entry,
            'unit' => $this->unit,
            'physical_stock_gallon' => $this->physical_stock_gallon,
            'stock_by_calculation_gallon' => $this->stock_by_calculation_gallon,
            'physical_stock_litre' => $this->physical_stock_litre,
            'stock_by_calculation_litre' => $this->stock_by_calculation_litre,
            'stock_difference_gallon' => $this->stock_difference_gallon,
            'stock_difference_litre' => $this->stock_difference_litre,
            'physica_data_entered_by' => $this->physica_data_entered_by,
            'closing_stock_gallon' => $this->closing_stock_gallon,
            'closing_stock_litre' => $this->closing_stock_litre,
            'sold_qty' => $this->sold_qty,
            'cash_sales' => $this->cash_sales,
            'card_sales' => $this->card_sales,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_by_type' => $this->created_by_type,
            'updated_by_type' => $this->updated_by_type,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'physical_stock', $this->physical_stock])
            ->andFilterWhere(['like', 'stock_by_calculation', $this->stock_by_calculation])
            ->andFilterWhere(['like', 'stock_difference', $this->stock_difference])
            ->andFilterWhere(['like', 'closing_stock', $this->closing_stock]);

        return $dataProvider;
    }
}
