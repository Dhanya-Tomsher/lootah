<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_dispenser".
 *
 * @property int $id
 * @property string $label
 * @property int $station_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $order_by
 * @property int $status
 */
class Dispenser extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lb_dispenser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['label', 'station_id', 'order_by', 'status'], 'required'],
            [['station_id', 'order_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'order_by' => 'Order By',
            'status' => 'Status',
        ];
    }

    public function getStation() {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }

}
