<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_station".
 *
 * @property int $id
 * @property string $station_name
 * @property string $location
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbStation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_station';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_name'], 'unique'],
            [['address'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['updated_at', 'created_by'], 'required'],
            [['created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['station_name', 'location', 'email', 'phone'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_name' => 'Station Name',
            'location' => 'Location',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
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
}
