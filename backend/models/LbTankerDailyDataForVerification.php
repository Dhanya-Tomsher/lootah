<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lb_tanker_daily_data_for_verification".
 *
 * @property int $id
 * @property int $tanker_id
 * @property string $date_entry
 * @property int $unit
 * @property double $physical_stock_gallon
 * @property double $stock_by_calculation_gallon
 * @property string $physical_stock
 * @property string $stock_by_calculation
 * @property string $stock_difference
 * @property string $closing_stock
 * @property double $physical_stock_litre
 * @property double $stock_by_calculation_litre
 * @property double $stock_difference_gallon
 * @property double $stock_difference_litre
 * @property int $physica_data_entered_by
 * @property double $closing_stock_gallon
 * @property int $closing_stock_litre
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
class LbTankerDailyDataForVerification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_tanker_daily_data_for_verification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanker_id', 'unit', 'physica_data_entered_by', 'closing_stock_litre', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['date_entry', 'created_at', 'updated_at'], 'safe'],
            [['physical_stock_gallon', 'stock_by_calculation_gallon', 'physical_stock_litre', 'stock_by_calculation_litre', 'stock_difference_gallon', 'stock_difference_litre', 'closing_stock_gallon', 'sold_qty', 'cash_sales', 'card_sales'], 'number'],
            [['physical_stock', 'stock_by_calculation', 'stock_difference', 'closing_stock'], 'string', 'max' => 255],
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
            'date_entry' => 'Date Entry',
            'unit' => 'Unit',
            'physical_stock_gallon' => 'Physical Stock Gallon',
            'stock_by_calculation_gallon' => 'Stock By Calculation Gallon',
            'physical_stock' => 'Physical Stock',
            'stock_by_calculation' => 'Stock By Calculation',
            'stock_difference' => 'Stock Difference',
            'closing_stock' => 'Closing Stock',
            'physical_stock_litre' => 'Physical Stock Litre',
            'stock_by_calculation_litre' => 'Stock By Calculation Litre',
            'stock_difference_gallon' => 'Stock Difference Gallon',
            'stock_difference_litre' => 'Stock Difference Litre',
            'physica_data_entered_by' => 'Physica Data Entered By',
            'closing_stock_gallon' => 'Closing Stock Gallon',
            'closing_stock_litre' => 'Closing Stock Litre',
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
}
