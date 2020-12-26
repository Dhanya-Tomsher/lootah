<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LbStationFilling;

/**
 * LbStationFillingSearch represents the model behind the search form of `common\models\LbStationFilling`.
 */
class LbStationFillingSearch extends LbStationFilling
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'filling_by', 'operator_id', 'supplier_id', 'tanker_id', 'tanker_operator_id', 'do_number', 'area_manager_approval_status', 'area_manager_approved_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['quantity_litre', 'quantity_gallon'], 'number'],
            [['date_entry', 'do_file', 'created_at', 'updated_at'], 'safe'],
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
        $query = LbStationFilling::find();

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
            'filling_by' => $this->filling_by,
            'operator_id' => $this->operator_id,
            'quantity_litre' => $this->quantity_litre,
            'quantity_gallon' => $this->quantity_gallon,
            'supplier_id' => $this->supplier_id,
            'tanker_id' => $this->tanker_id,
            'tanker_operator_id' => $this->tanker_operator_id,
            'date_entry' => $this->date_entry,
            'do_number' => $this->do_number,
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

        $query->andFilterWhere(['like', 'do_file', $this->do_file]);

        return $dataProvider;
    }
}
