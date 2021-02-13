<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "lb_stock_request_management".
 *
 * @property int $id
 * @property int $request_id
 * @property int $supplier_id
 * @property double $quantity_litre
 * @property double $quantity_gallon
 * @property string $date_entry
 * @property string $supply_date
 * @property string $supply_time
 * @property int $assigned_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbStockRequestManagement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_stock_request_management';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'supplier_id','station_id', 'assigned_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['quantity_litre', 'quantity_gallon'], 'number'],
            [['date_entry', 'supply_date', 'created_at', 'updated_at'], 'safe'],
            [['supply_time'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'supplier_id' => 'Supplier ID',
            'quantity_litre' => 'Quantity Litre',
            'quantity_gallon' => 'Quantity Gallon',
            'date_entry' => 'Date Entry',
            'supply_date' => 'Supply Date',
            'supply_time' => 'Supply Time',
            'assigned_by' => 'Assigned By',
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
    
    public function search($params) {
        $query = LbStockRequestManagement::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->FilterWhere([
            'supply_status' => 1,
        ]);
        
         if (isset($this->supply_date) && $this->supply_date != "") {
            $date_from = date('Y-m-d', strtotime($this->supply_date));
            $query->andWhere("supply_date >=  '" . $date_from . "'");
        }
        if (isset($this->created_at) && $this->created_at != "") {
            $date_to = date('Y-m-d', strtotime($this->created_at));
            $query->andWhere("supply_date <=  '" . $date_to . "'");
        }
        

        $query->andFilterWhere([
            'station_id' => $this->station_id,
        ]);
       $query->andFilterWhere([
            'supplier_id' => $this->supplier_id,
        ]);

        return $dataProvider;
    }
    public function getStation()
    {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }
    public function getSupplier()
    {
        return $this->hasOne(LbSupplier::className(), ['id' => 'supplier_id']);
    }
}
