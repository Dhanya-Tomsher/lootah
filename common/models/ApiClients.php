<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "api_clients".
 *
 * @property int $id
 * @property string $client_id
 * @property string $client_secret
 * @property string $created_time
 * @property string $access_token
 * @property int $status
 * @property string $expire_time
 * @property int $created_by
 * @property string $client_ip
 */
class ApiClients extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['client_id', 'client_secret', 'created_by', 'name', 'refresh_token'], 'required'],
            [['created_time', 'expire_time'], 'safe'],
            [['status', 'created_by'], 'integer'],
            [['client_id'], 'string', 'max' => 250],
            [['client_secret', 'access_token'], 'string', 'max' => 255],
            [['client_ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'created_time' => 'Created Time',
            'access_token' => 'Access Token',
            'status' => 'Status',
            'expire_time' => 'Expire Time',
            'created_by' => 'Created By',
            'client_ip' => 'Client Ip',
        ];
    }

}
