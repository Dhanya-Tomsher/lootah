<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_transaction".
 *
 * @property string $UUID
 * @property int $transaction_no
 * @property int $ReferenceId
 * @property int $SequenceId
 * @property int $DeviceId
 * @property string $Meter
 * @property string $SecondaryTag
 * @property string $Category
 * @property string $Operator
 * @property string $Asset
 * @property string $AccumulatorType
 * @property string $Sitecode
 * @property string $Project
 * @property string $PlateNo
 * @property string $Master
 * @property int $Accumulator
 * @property string $Volume
 * @property string $Allowance
 * @property string $Type
 * @property string $StartTime
 * @property string $EndTime
 * @property string $Status
 * @property string $ServerTimestamp
 * @property string $UpdateTimestamp
 */
class Transaction extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lb_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['UUID', 'transaction_no', 'SequenceId', 'DeviceId', 'Meter', 'SecondaryTag', 'Operator', 'Asset', 'AccumulatorType', 'Sitecode', 'Project', 'PlateNo', 'Master', 'Accumulator', 'Volume', 'Type', 'StartTime', 'EndTime', 'Status', 'ServerTimestamp', 'UpdateTimestamp', 'dispenser_id', 'station_id', 'nozle_id'], 'required'],
            [['transaction_no', 'ReferenceId', 'SequenceId', 'DeviceId', 'Accumulator'], 'integer'],
            [['Volume'], 'number'],
            [['UUID'], 'string', 'max' => 254],
            [['Meter'], 'string', 'max' => 255],
            [['SecondaryTag'], 'string', 'max' => 200],
            [['Category'], 'string', 'max' => 50],
            [['Operator', 'StartTime', 'EndTime', 'ServerTimestamp', 'UpdateTimestamp'], 'string', 'max' => 100],
            [['Asset', 'Master', 'Allowance', 'Type'], 'string', 'max' => 20],
            [['AccumulatorType', 'Project', 'PlateNo'], 'string', 'max' => 10],
            [['Sitecode', 'Status'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'UUID' => 'Uuid',
            'transaction_no' => 'Transaction No',
            'ReferenceId' => 'Reference ID',
            'SequenceId' => 'Sequence ID',
            'DeviceId' => 'Device ID',
            'Meter' => 'Meter',
            'SecondaryTag' => 'Secondary Tag',
            'Category' => 'Category',
            'Operator' => 'Operator',
            'Asset' => 'Asset',
            'AccumulatorType' => 'Accumulator Type',
            'Sitecode' => 'Sitecode',
            'Project' => 'Project',
            'PlateNo' => 'Plate No',
            'Master' => 'Master',
            'Accumulator' => 'Accumulator',
            'Volume' => 'Volume',
            'Allowance' => 'Allowance',
            'Type' => 'Type',
            'StartTime' => 'Start Time',
            'EndTime' => 'End Time',
            'Status' => 'Status',
            'ServerTimestamp' => 'Server Timestamp',
            'UpdateTimestamp' => 'Update Timestamp',
        ];
    }

    public function getStation() {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }

    public function getDispenser() {
        return $this->hasOne(Dispenser::className(), ['id' => 'dispenser_id']);
    }

    public function getNozzle() {
        return $this->hasOne(Nozzle::className(), ['device_ref_no' => 'Meter']);
    }

    public function getDevice() {
        return $this->hasOne(Device::className(), ['device_id' => 'DeviceId']);
    }

}
