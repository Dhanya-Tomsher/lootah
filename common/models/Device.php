<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_device".
 *
 * @property int $id
 * @property int $device_id
 * @property string $name
 * @property string $uid
 * @property string $description
 * @property int $softwareId
 * @property int $status
 * @property string $updated
 * @property string $mobile
 * @property string $timestamp
 * @property int $station_id
 * @property int $dispenser_id
 * @property int $nozle_id
 * @property string $device_ref_id
 */
class Device extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lb_device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['device_id', 'name', 'uid', 'description', 'softwareId', 'status', 'updated', 'mobile', 'timestamp', 'station_id', 'dispenser_id', 'nozle_id', 'device_ref_id'], 'required'],
            [['device_id', 'softwareId', 'status', 'station_id', 'dispenser_id', 'nozle_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['uid', 'updated', 'timestamp'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 11],
            [['device_ref_id'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'device_id' => 'Device ID',
            'name' => 'Name',
            'uid' => 'Uid',
            'description' => 'Description',
            'softwareId' => 'Software ID',
            'status' => 'Status',
            'updated' => 'Updated',
            'mobile' => 'Mobile',
            'timestamp' => 'Timestamp',
            'station_id' => 'Station ID',
            'dispenser_id' => 'Dispenser ID',
            'nozle_id' => 'Nozle ID',
            'device_ref_id' => 'Device Ref ID',
        ];
    }

    public function getStation() {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }

    public function getDispenser() {
        return $this->hasOne(Dispenser::className(), ['id' => 'dispenser_id']);
    }

    public function getNozzle() {
        return $this->hasOne(Dispenser::className(), ['device_ref_no' => 'device_ref_id']);
    }

}
