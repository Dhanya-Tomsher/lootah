<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_configuration".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $additional_email
 * @property int $phone
 * @property int $office
 * @property int $fax
 * @property string $additional_phone
 * @property string $latitude
 * @property string $lonigtude
 * @property string $logo
 * @property string $fav
 * @property string $facebook
 * @property string $youtube
 * @property string $instagram
 * @property string $twitter
 * @property string $platform
 * @property int $status
 * @property string $seo_title
 * @property string $feild1
 * @property string $feild2
 * @property string $created_at
 * @property string $updated_at
 * @property string $seo_keyword
 * @property string $seo_description
 * @property string $crm_access_token
 * @property string $token_last_updated_on
 * @property string $merchant_id
 * @property string $merchant_key
 * @property string $buffer_time
 * @property string $gateway_url
 * @property string $crm_username
 * @property string $crm_password
 * @property string $crm_client_id
 * @property string $crm_secret
 * @property string $dms_user_name
 * @property string $dms_password
 * @property string $dms_access_token
 * @property string $dms_token_last_updated_on
 * @property string $dms_base_url
 * @property string $website
 * @property int $notice_period
 */
class Configuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'email', 'additional_email', 'phone', 'additional_phone', 'latitude', 'lonigtude', 'logo', 'fav', 'facebook', 'youtube', 'instagram', 'twitter', 'platform', 'status', 'seo_title', 'feild1', 'feild2', 'seo_keyword', 'seo_description', 'crm_access_token', 'token_last_updated_on', 'merchant_id', 'merchant_key', 'buffer_time', 'gateway_url', 'crm_username', 'crm_password', 'crm_client_id', 'crm_secret', 'dms_user_name', 'dms_password', 'dms_access_token', 'dms_token_last_updated_on', 'dms_base_url', 'website', 'notice_period'], 'required'],
            [['id', 'phone', 'office', 'fax', 'status', 'notice_period'], 'integer'],
            [['additional_email', 'additional_phone', 'seo_keyword', 'seo_description', 'crm_access_token', 'gateway_url', 'crm_client_id', 'crm_secret', 'dms_access_token', 'dms_base_url'], 'string'],
            [['created_at', 'updated_at', 'token_last_updated_on', 'dms_token_last_updated_on'], 'safe'],
            [['name', 'merchant_id', 'dms_user_name', 'dms_password'], 'string', 'max' => 100],
            [['email', 'latitude', 'lonigtude'], 'string', 'max' => 40],
            [['logo', 'fav'], 'string', 'max' => 50],
            [['facebook', 'youtube', 'instagram', 'twitter', 'seo_title', 'feild1', 'feild2', 'website'], 'string', 'max' => 255],
            [['platform'], 'string', 'max' => 30],
            [['merchant_key'], 'string', 'max' => 250],
            [['buffer_time'], 'string', 'max' => 10],
            [['crm_username', 'crm_password'], 'string', 'max' => 200],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'additional_email' => 'Additional Email',
            'phone' => 'Phone',
            'office' => 'Office',
            'fax' => 'Fax',
            'additional_phone' => 'Additional Phone',
            'latitude' => 'Latitude',
            'lonigtude' => 'Lonigtude',
            'logo' => 'Logo',
            'fav' => 'Fav',
            'facebook' => 'Facebook',
            'youtube' => 'Youtube',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'platform' => 'Platform',
            'status' => 'Status',
            'seo_title' => 'Seo Title',
            'feild1' => 'Feild1',
            'feild2' => 'Feild2',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'seo_keyword' => 'Seo Keyword',
            'seo_description' => 'Seo Description',
            'crm_access_token' => 'Crm Access Token',
            'token_last_updated_on' => 'Token Last Updated On',
            'merchant_id' => 'Merchant ID',
            'merchant_key' => 'Merchant Key',
            'buffer_time' => 'Buffer Time',
            'gateway_url' => 'Gateway Url',
            'crm_username' => 'Crm Username',
            'crm_password' => 'Crm Password',
            'crm_client_id' => 'Crm Client ID',
            'crm_secret' => 'Crm Secret',
            'dms_user_name' => 'Dms User Name',
            'dms_password' => 'Dms Password',
            'dms_access_token' => 'Dms Access Token',
            'dms_token_last_updated_on' => 'Dms Token Last Updated On',
            'dms_base_url' => 'Dms Base Url',
            'website' => 'Website',
            'notice_period' => 'Notice Period',
        ];
    }
}
