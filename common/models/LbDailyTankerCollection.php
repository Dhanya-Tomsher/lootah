<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_daily_tanker_collection".
 *
 * @property int $id
 * @property int $tanker_id
 * @property int $operator_id
 * @property int $client_type
 * @property int $vehicle_id
 * @property int $collection_type
 * @property double $quantity_gallon
 * @property double $quantity_litre
 * @property double $amount_litre
 * @property double $amount_gallon
 * @property int $supervisor_approval_status
 * @property int $supervisor_approved_by
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
class LbDailyTankerCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_daily_tanker_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanker_id', 'operator_id', 'client_type', 'vehicle_id', 'collection_type', 'supervisor_approval_status', 'supervisor_approved_by', 'area_manager_approval_status', 'area_manager_approved_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['quantity_gallon', 'quantity_litre', 'amount_litre', 'amount_gallon'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
            'operator_id' => 'Operator ID',
            'client_type' => 'Client Type',
            'vehicle_id' => 'Vehicle ID',
            'collection_type' => 'Collection Type',
            'quantity_gallon' => 'Quantity Gallon',
            'quantity_litre' => 'Quantity Litre',
            'amount' => 'Amount',
            'supervisor_approval_status' => 'Supervisor Approval Status',
            'supervisor_approved_by' => 'Supervisor Approved By',
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
     public function getOperator()
    {
        return $this->hasOne(LbTankerOperator::className(), ['id' => 'operator_id']);
    }
    public function getTanker()
    {
        return $this->hasOne(LbTanker::className(), ['id' => 'tanker_id']);
    }
}
