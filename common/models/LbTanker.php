<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_tanker".
 *
 * @property int $id
 * @property string $tanker_number
 * @property int $station_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 *
 * @property LbStation $station
 */
class LbTanker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_tanker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanker_number'], 'unique'],
            [['station_id', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['tanker_number'], 'string', 'max' => 45],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => LbStation::className(), 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanker_number' => 'Tanker Number',
            'station_id' => 'Station ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStation()
    {
        return $this->hasOne(LbStation::className(), ['id' => 'station_id']);
    }
}
