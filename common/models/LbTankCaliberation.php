<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "lb_tank_caliberation".
 *
 * @property int $id
 * @property string $station_id
 * @property string $physical_quantity
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbTankCaliberation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_tank_caliberation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['station_id', 'physical_quantity'], 'string', 'max' => 45],
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
            'physical_quantity' => 'Physical Quantity',
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
        $query = LbTankCaliberation::find();

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
        
         if (isset($this->date_caliberation) && $this->date_caliberation != "") {
            $date_from = date('Y-m-d', strtotime($this->date_caliberation));
            $query->andWhere("date_caliberation >=  '" . $date_from . "'");
        }
        if (isset($this->created_at) && $this->created_at != "") {
            $date_to = date('Y-m-d', strtotime($this->created_at));
            $query->andWhere("date_caliberation <=  '" . $date_to . "'");
        }
        

        $query->andFilterWhere([
            'station_id' => $this->station_id,
        ]);
       

        return $dataProvider;
    }
    
}
