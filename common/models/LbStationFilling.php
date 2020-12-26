<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_station_filling".
 *
 * @property int $id
 * @property int $station_id
 * @property int $filling_by
 * @property int $operator_id
 * @property double $quantity_litre
 * @property double $quantity_gallon
 * @property int $supplier_id
 * @property int $tanker_id
 * @property int $tanker_operator_id
 * @property string $date_entry
 * @property int $do_number
 * @property string $do_file
 * @property int $area_manager_approval_status
 * @property int $area_manager_approved_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbStationFilling extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_station_filling';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id', 'filling_by', 'operator_id', 'supplier_id', 'tanker_id', 'tanker_operator_id', 'do_number', 'area_manager_approval_status', 'area_manager_approved_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['quantity_litre', 'quantity_gallon'], 'number'],
            [['date_entry', 'created_at', 'updated_at'], 'safe'],
            [['do_file'], 'string', 'max' => 45],
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
            'filling_by' => 'Filling By',
            'operator_id' => 'Operator ID',
            'quantity_litre' => 'Quantity Litre',
            'quantity_gallon' => 'Quantity Gallon',
            'supplier_id' => 'Supplier ID',
            'tanker_id' => 'Tanker ID',
            'tanker_operator_id' => 'Tanker Operator ID',
            'date_entry' => 'Date Entry',
            'do_number' => 'Do Number',
            'do_file' => 'Do File',
            'area_manager_approval_status' => 'Area Manager Approval Status',
            'area_manager_approved_by' => 'Area Manager Approved By',
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
}
