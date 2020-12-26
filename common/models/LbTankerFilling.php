<?php

namespace common\models;

use Yii;

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
}
