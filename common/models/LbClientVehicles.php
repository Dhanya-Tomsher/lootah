<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_client_vehicles".
 *
 * @property int $id
 * @property int $client_id
 * @property int $department_id
 * @property int $vehicle_type
 * @property string $vehicle_number
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbClientVehicles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_client_vehicles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'department_id', 'vehicle_type', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['vehicle_number'], 'string', 'max' => 45],
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
            'department_id' => 'Department ID',
            'vehicle_type' => 'Vehicle Type',
            'vehicle_number' => 'Vehicle Number',
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
        return $this->hasOne(LbClientDepartments::className(), ['id' => 'department_id']);
    }
    public function getVehicletype()
    {
        return $this->hasOne(LbVehicleType::className(), ['id' => 'vehicle_type']);
    }
}
