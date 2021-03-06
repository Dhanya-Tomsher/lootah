<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\models\Transaction`.
 */
class TransactionSearch extends Transaction {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['UUID', 'Meter', 'SecondaryTag', 'Category', 'Operator', 'Asset', 'AccumulatorType', 'Sitecode', 'Project', 'PlateNo', 'Master', 'Allowance', 'Type', 'StartTime', 'EndTime', 'Status', 'ServerTimestamp', 'UpdateTimestamp', 'dispenser_id', 'station_id', 'nozle_id', 'device_type', 'date_from', 'date_to', 'client_id'], 'safe'],
            [['transaction_no', 'ReferenceId', 'SequenceId', 'DeviceId', 'Accumulator'], 'integer'],
            [['Volume'], 'number'],
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
        $query = Transaction::find();

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

        if (isset($this->client_id) && $this->client_id != "") {
            if ($this->PlateNo != "") {
                $query->andWhere("PlateNo =  '" . $this->PlateNo . "'");
            } else {
                $get_vehicle_list = LbClientVehicles::find()->where(['client_id' => $this->client_id])->all();

                $get_veh_list = [];

                if ($get_vehicle_list != NULL) {
                    foreach ($get_vehicle_list as $get_vehicle_li) {
                        $get_veh_list[] = $get_vehicle_li->vehicle_number;
                    }
                }


                $query->andWhere(['IN', 'PlateNo', $get_veh_list]);
            }
        }
        if (isset($this->date_from) && $this->date_from != "") {
            $date_from = date('Y-m-d H:i:s', strtotime($this->date_from));
            //echo $date_from;
            $query->andWhere("EndTime >=  '" . $date_from . "'");
        }
        if (isset($this->date_to) && $this->date_to != "") {
            $date_to = date('Y-m-d H:i:s', strtotime($this->date_to));
            // echo $date_to;
            //echo "...";
            $query->andWhere("EndTime <=  '" . $date_to . "'");
            //exit;
        }
//        if (isset($_GET['device_type']) && $_GET['device_type'] != "") {
//            $query->andFilterWhere(['device_type' => $_GET['device_type']]);
//        }
//        if (isset($_GET['dispenser_id']) && $_GET['dispenser_id'] != "") {
//            $query->andFilterWhere(['dispenser_id' => $_GET['dispenser_id']]);
//        }
//        if (isset($_GET['station_id']) && $_GET['station_id'] != "") {
//            $query->andFilterWhere(['station_id' => $_GET['station_id']]);
//
//        }
//        if (isset($_GET['nozle_id']) && $_GET['nozle_id'] != "") {
//            $query->andFilterWhere(['nozle_id' => $_GET['nozle_id']]);
//        }
//        if (isset($_GET['transaction_no']) && $_GET['transaction_no'] != "") {
//            $query->andFilterWhere(['transaction_no' => $_GET['transaction_no']]);
//        }
        // grid filtering conditions
        $query->andFilterWhere([
            'transaction_no' => $this->transaction_no,
            'ReferenceId' => $this->ReferenceId,
            'SequenceId' => $this->SequenceId,
            'DeviceId' => $this->DeviceId,
            'Accumulator' => $this->Accumulator,
            'station_id' => $this->station_id,
            'dispenser_id' => $this->dispenser_id,
            'nozle_id' => $this->nozle_id,
            'Volume' => $this->Volume,
        ]);

        $query->andFilterWhere(['like', 'UUID', $this->UUID])
                ->andFilterWhere(['like', 'Meter', $this->Meter])
                ->andFilterWhere(['like', 'device_type', $this->device_type])
                ->andFilterWhere(['like', 'SecondaryTag', $this->SecondaryTag])
                ->andFilterWhere(['like', 'Category', $this->Category])
                ->andFilterWhere(['like', 'Operator', $this->Operator])
                ->andFilterWhere(['like', 'Asset', $this->Asset])
                ->andFilterWhere(['like', 'AccumulatorType', $this->AccumulatorType])
                ->andFilterWhere(['like', 'Sitecode', $this->Sitecode])
                ->andFilterWhere(['like', 'Project', $this->Project])
                ->andFilterWhere(['like', 'PlateNo', $this->PlateNo])
                ->andFilterWhere(['like', 'Master', $this->Master])
                ->andFilterWhere(['like', 'Allowance', $this->Allowance])
                ->andFilterWhere(['like', 'Type', $this->Type])
                ->andFilterWhere(['like', 'StartTime', $this->StartTime])
//                ->andFilterWhere(['like', 'EndTime', $this->EndTime])
                ->andFilterWhere(['like', 'Status', $this->Status])
                ->andFilterWhere(['like', 'ServerTimestamp', $this->ServerTimestamp])
                ->andFilterWhere(['like', 'UpdateTimestamp', $this->UpdateTimestamp]);

        return $dataProvider;
    }

}
