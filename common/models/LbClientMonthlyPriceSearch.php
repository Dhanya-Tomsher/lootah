<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbClientMonthlyPrice;

/**
 * LbClientMonthlyPriceSearch represents the model behind the search form of `common\models\LbClientMonthlyPrice`.
 */
class LbClientMonthlyPriceSearch extends LbClientMonthlyPrice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'month', 'status'], 'integer'],
            [['govt_price', 'discount', 'customer_price', 'year'], 'number'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order'], 'safe'],
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
        $query = LbClientMonthlyPrice::find();

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
            'govt_price' => $this->govt_price,
            'discount' => $this->discount,
            'customer_price' => $this->customer_price,
            'month' => $this->month,
            'year' => $this->year,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'created_by_type', $this->created_by_type])
            ->andFilterWhere(['like', 'updated_by_type', $this->updated_by_type])
            ->andFilterWhere(['like', 'sort_order', $this->sort_order]);

        return $dataProvider;
    }
}
