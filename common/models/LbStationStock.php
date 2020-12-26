<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_station_stock".
 *
 * @property int $id
 * @property int $station_id
 * @property double $opening_stock_litre
 * @property double $opening_stock_gallon
 * @property double $supplier_purchase_litre
 * @property double $supplier_purchase_gallon
 * @property double $tanker_load_litre
 * @property double $tanker_load_gallon
 * @property double $tanker_unload_litre
 * @property double $tanker_unload_gallon
 * @property double $station_sale_litre
 * @property double $station_sale_gallon
 * @property double $total_intake_litre
 * @property double $total_intake_gallon
 * @property double $total_out_litre
 * @property double $total_out_gallon
 * @property double $stock_in_dispenser_litre
 * @property double $stock_in_dispenser_gallon
 * @property string $date_entry
 * @property int $day_entry
 * @property int $month_entry
 * @property int $year_entry
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbStationStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_station_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id', 'day_entry', 'month_entry', 'year_entry', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['opening_stock_litre', 'opening_stock_gallon', 'supplier_purchase_litre', 'supplier_purchase_gallon', 'tanker_load_litre', 'tanker_load_gallon', 'tanker_unload_litre', 'tanker_unload_gallon', 'station_sale_litre', 'station_sale_gallon', 'total_intake_litre', 'total_intake_gallon', 'total_out_litre', 'total_out_gallon', 'stock_in_dispenser_litre', 'stock_in_dispenser_gallon'], 'number'],
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
            'station_id' => 'Station ID',
            'opening_stock_litre' => 'Opening Stock Litre',
            'opening_stock_gallon' => 'Opening Stock Gallon',
            'supplier_purchase_litre' => 'Supplier Purchase Litre',
            'supplier_purchase_gallon' => 'Supplier Purchase Gallon',
            'tanker_load_litre' => 'Tanker Load Litre',
            'tanker_load_gallon' => 'Tanker Load Gallon',
            'tanker_unload_litre' => 'Tanker Unload Litre',
            'tanker_unload_gallon' => 'Tanker Unload Gallon',
            'station_sale_litre' => 'Station Sale Litre',
            'station_sale_gallon' => 'Station Sale Gallon',
            'total_intake_litre' => 'Total Intake Litre',
            'total_intake_gallon' => 'Total Intake Gallon',
            'total_out_litre' => 'Total Out Litre',
            'total_out_gallon' => 'Total Out Gallon',
            'stock_in_dispenser_litre' => 'Stock In Dispenser Litre',
            'stock_in_dispenser_gallon' => 'Stock In Dispenser Gallon',
            'date_entry' => 'Date Entry',
            'day_entry' => 'Day Entry',
            'month_entry' => 'Month Entry',
            'year_entry' => 'Year Entry',
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
}
