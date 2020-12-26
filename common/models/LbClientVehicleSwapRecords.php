<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_client_vehicle_swap_records".
 *
 * @property int $id
 * @property int $client_id
 * @property int $old_department
 * @property int $old_vehicle
 * @property int $new_department
 * @property int $new_vehicle
 * @property string $date_replacement
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbClientVehicleSwapRecords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_client_vehicle_swap_records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'old_department', 'old_vehicle',  'new_vehicle', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['date_replacement', 'created_at', 'updated_at'], 'safe'],
            [['created_at', 'updated_at'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'old_department' => 'Department',
            'old_vehicle' => 'Old Vehicle',
            'new_department' => 'New Department',
            'new_vehicle' => 'New Vehicle',
            'date_replacement' => 'Date Replacement',
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
    public function getClient()
    {
        return $this->hasOne(LbClients::className(), ['id' => 'client_id']);
    }
    public function getDepartment()
    {
        return $this->hasOne(LbClientDepartments::className(), ['id' => 'old_department']);
    }
    public function getVehicle()
    {
        return $this->hasOne(LbClientVehicles::className(), ['id' => 'old_vehicle']);
    }
    public function getVehiclen()
    {
        return $this->hasOne(LbClientVehicles::className(), ['id' => 'new_vehicle']);
    }
}
