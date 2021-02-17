<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "lb_tanker_filling".
 *
 * @property int $id
 * @property int $tanker_id
 * @property int $station_id
 * @property int $tanker_operator
 * @property int $station_operator
 * @property double $quantity_litre
 * @property double $quantity_gallon
 * @property string $date_entry
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbTankerFilling extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_tanker_filling';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanker_id', 'station_id', 'tanker_operator', 'station_operator', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['quantity_litre', 'quantity_gallon'], 'number'],
            [['date_entry', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanker_id' => 'Tanker ID',
            'station_id' => 'Station ID',
            'tanker_operator' => 'Tanker Operator',
            'station_operator' => 'Station Operator',
            'quantity_litre' => 'Quantity Litre',
            'quantity_gallon' => 'Quantity Gallon',
            'date_entry' => 'Date Entry',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_by_type' => 'Created By Type',
            'updated_by_type' => 'Updated By Type',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
        ];
    }
    
    public function getStation()
    {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }
    public function getStationoperator()
    {
        return $this->hasOne(LbStationOperator::className(), ['id' => 'station_operator']);
    }
    public function getTankeroperator()
    {
        return $this->hasOne(LbTankerOperator::className(), ['id' => 'tanker_operator']);
    }
    public function getTanker()
    {
        return $this->hasOne(LbTanker::className(), ['id' => 'tanker_id']);
    }
    public function search($params) {
        $query = LbTankerFilling::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->FilterWhere([
            'transaction_type' => 2,
        ]);
        $query->andFilterWhere([
            'status' => 1,
        ]);
        
         if (isset($this->date_entry) && $this->date_entry != "") {
            $date_from = date('Y-m-d', strtotime($this->date_entry));
            $query->andWhere("date_entry >=  '" . $date_from . "'");
        }
        if (isset($this->created_at) && $this->created_at != "") {
            $date_to = date('Y-m-d', strtotime($this->created_at));
            $query->andWhere("date_entry <=  '" . $date_to . "'");
        }        

        $query->andFilterWhere([
            'station_id' => $this->station_id,
        ]);
       
        $query->andFilterWhere([
            'tanker_id' => $this->tanker_id,
        ]);
        return $dataProvider;
    }
}
