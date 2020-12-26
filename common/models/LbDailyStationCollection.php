<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_daily_station_collection".
 *
 * @property int $id
 * @property int $station_id
 * @property int $operator_id
 * @property int $nozzle
 * @property int $client_type
 * @property int $client_id
 * @property int $vehicle_id
 * @property int $vehicle_number
 * @property int $odometer_reading
 * @property int $collection_type
 * @property double $quantity_gallon
 * @property double $quantity_litre
 * @property double $amount
 * @property double $opening_stock
 * @property double $closing_stock
 * @property int $edited_by
 * @property string $description_for_edit
 * @property int $edit_approval_status
 * @property int $edit_approved_by
 * @property string $edit_approval_comments
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 * @property int $supervisor_verification_status
 * @property int $supervisor_verified_by
 * @property int $area_manager_verification_status
 * @property int $area_manager_verified_by
 */
class LbDailyStationCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_daily_station_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'station_id', 'operator_id', 'nozzle', 'client_type', 'client_id', 'vehicle_id',  'odometer_reading', 'collection_type', 'edited_by', 'edit_approval_status', 'edit_approved_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status', 'supervisor_verification_status', 'supervisor_verified_by', 'area_manager_verification_status', 'area_manager_verified_by'], 'integer'],
            [['quantity_gallon', 'quantity_litre', 'amount', 'opening_stock', 'closing_stock'], 'number'],
            [['description_for_edit', 'edit_approval_comments'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'unique'],
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
            'operator_id' => 'Operator ID',
            'nozzle' => 'Nozzle',
            'client_type' => 'Client Type',
            'client_id' => 'Client ID',
            'vehicle_id' => 'Vehicle ID',
            'vehicle_number' => 'Vehicle Number',
            'odometer_reading' => 'Odometer Reading',
            'collection_type' => 'Collection Type',
            'quantity_gallon' => 'Quantity Gallon',
            'quantity_litre' => 'Quantity Litre',
            'amount' => 'Amount',
            'opening_stock' => 'Opening Stock',
            'closing_stock' => 'Closing Stock',
            'edited_by' => 'Edited By',
            'description_for_edit' => 'Description For Edit',
            'edit_approval_status' => 'Edit Approval Status',
            'edit_approved_by' => 'Edit Approved By',
            'edit_approval_comments' => 'Edit Approval Comments',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_by_type' => 'Created By Type',
            'updated_by_type' => 'Updated By Type',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'supervisor_verification_status' => 'Supervisor Verification Status',
            'supervisor_verified_by' => 'Supervisor Verified By',
            'area_manager_verification_status' => 'Area Manager Verification Status',
            'area_manager_verified_by' => 'Area Manager Verified By',
        ];
    }
    public function getOperator()
    {
        return $this->hasOne(LbStationOperator::className(), ['id' => 'operator_id']);
    }
    public function getStation()
    {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }
}
