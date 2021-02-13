<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "lb_tank_cleaning_report".
 *
 * @property int $id
 * @property int $station_id
 * @property string $date_cleaning
 * @property string $next_date_cleaning
 * @property double $tank_capacity_gallon
 * @property int $supervisor_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbTankCleaningReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_tank_cleaning_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id', 'supervisor_id', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['date_cleaning', 'next_date_cleaning', 'created_at', 'updated_at'], 'safe'],
            [['tank_capacity_gallon'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'date_cleaning' => 'Date Cleaning',
            'next_date_cleaning' => 'Next Date Cleaning',
            'tank_capacity_gallon' => 'Tank Capacity',
            'supervisor_id' => 'Supervisor ID',
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
    
    public function search($params) {
        $query = LbTankCleaningReport::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->FilterWhere([
            'status' => 1,
        ]);
        
         if (isset($this->date_cleaning) && $this->date_cleaning != "") {
            $date_from = date('Y-m-d', strtotime($this->date_cleaning));
            $query->andWhere("date_cleaning >=  '" . $date_from . "'");
        }
        if (isset($this->created_at) && $this->created_at != "") {
            $date_to = date('Y-m-d', strtotime($this->created_at));
            $query->andWhere("date_cleaning <=  '" . $date_to . "'");
        }
        

        $query->andFilterWhere([
            'station_id' => $this->station_id,
        ]);
       

        return $dataProvider;
    }
    
}
