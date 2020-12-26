<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_operator_tanker_assignment".
 *
 * @property int $id
 * @property int $operator_id
 * @property int $tanker_id
 * @property int $assigned_by
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
class LbOperatorTankerAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_operator_tanker_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operator_id', 'tanker_id', 'assigned_by', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
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
            'tanker_id' => 'Tanker ID',
            'assigned_by' => 'Assigned By',
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
    public function getOperator()
    {
        return $this->hasOne(LbTankerOperator::className(), ['id' => 'operator_id']);
    }
     public function getTanker()
    {
        return $this->hasOne(LbTanker::className(), ['id' => 'tanker_id']);
    }
     public function getSupervisor()
    {
        return $this->hasOne(LbSupervisor::className(), ['id' => 'assigned_by']);
    }
}
