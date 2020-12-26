<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_station_daily_data_for_verification".
 *
 * @property int $id
 * @property int $station_id
 * @property string $date_entry
 * @property int $unit
 * @property double $physical_stock
 * @property double $stock_by_calculation
 * @property double $stock_difference
 * @property int $physica_data_entered_by
 * @property double $closing_stock
 * @property double $sold_qty
 * @property double $cash_sales
 * @property double $card_sales
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbStationDailyDataForVerification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_station_daily_data_for_verification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id', 'unit', 'physica_data_entered_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['date_entry', 'created_at', 'updated_at'], 'safe'],
            [['physical_stock', 'stock_by_calculation', 'stock_difference', 'closing_stock', 'sold_qty', 'cash_sales', 'card_sales'], 'number'],
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
            'date_entry' => 'Date Entry',
            'unit' => 'Unit',
            'physical_stock' => 'Physical Stock',
            'stock_by_calculation' => 'Stock By Calculation',
            'stock_difference' => 'Stock Difference',
            'physica_data_entered_by' => 'Physica Data Entered By',
            'closing_stock' => 'Closing Stock',
            'sold_qty' => 'Sold Qty',
            'cash_sales' => 'Cash Sales',
            'card_sales' => 'Card Sales',
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
    public function getUnitvalue()
    {
        return $this->hasOne(LbPhysicalQuantityUnit::className(), ['id' => 'unit']);
    }
}
