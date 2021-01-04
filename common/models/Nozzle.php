<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_nozzle".
 *
 * @property int $id
 * @property string $label
 * @property int $station_id
 * @property int $dispenser_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property int $order_by
 */
class Nozzle extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lb_nozzle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['label', 'station_id', 'dispenser_id', 'status', 'order_by'], 'required'],
            [['station_id', 'dispenser_id', 'status', 'order_by'], 'integer'],
            [['created_at', 'updated_at', 'device_ref_no'], 'safe'],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'station_id' => 'Station ID',
            'dispenser_id' => 'Dispenser ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'order_by' => 'Order By',
        ];
    }

    public function getStation() {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }

    public function getDispenser() {
        return $this->hasOne(Dispenser::className(), ['id' => 'dispenser_id']);
    }

}
