<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_operator_station_assignment".
 *
 * @property int $id
 * @property int $operator_id
 * @property int $station_id
 * @property int $assigned_by
 * @property string $date_assignment
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbOperatorStationAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_operator_station_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operator_id', 'station_id', 'assigned_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['date_assignment', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operator_id' => 'Operator ID',
            'station_id' => 'Station ID',
            'assigned_by' => 'Assigned By',
            'date_assignment' => 'Date Assignment',
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
        return $this->hasOne(LbStationOperator::className(), ['id' => 'operator_id']);
    }
     public function getStation()
    {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }
     public function getSupervisor()
    {
        return $this->hasOne(LbSupervisor::className(), ['id' => 'assigned_by']);
    }
}
