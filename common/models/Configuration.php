<?php

namespace common\models;

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
 * @property double $latitude
 * @property double $lonigtude
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
 */
class Configuration extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tbl_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'email', 'platform', 'status'], 'required'],
            [['additional_email', 'additional_phone', 'seo_keyword', 'seo_description'], 'string'],
            [['phone', 'office', 'fax', 'status'], 'integer'],
//            [['latitude', 'lonigtude'], 'number'],
            [['created_at', 'updated_at', 'merchant_id', 'merchant_key', 'crm_username', 'gateway_url', 'crm_password', 'crm_client_id', 'crm_secret', 'dms_user_name', 'dms_password', 'dms_access_token', 'dms_token_last_updated_on', 'dms_base_url'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 40],
//            [['logo', 'fav'], 'string', 'max' => 50],
            [['facebook', 'youtube', 'instagram', 'twitter', 'seo_title', 'feild1', 'feild2'], 'string', 'max' => 255],
            [['platform'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'merchant_key' => 'merchant key',
            'merchant_id' => 'merchant id',
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
        ];
    }

    public function uploadFile($file, $id) {

        $targetFolder = \yii::$app->basePath . '/../uploads/configuration/' . $id . '/';
        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }
        if ($file->saveAs($targetFolder . 'logo.' . $file->extension)) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadFav($file, $id) {

        $targetFolder = \yii::$app->basePath . '/../uploads/configuration/' . $id . '/';
        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }
        if ($file->saveAs($targetFolder . 'fav.' . $file->extension)) {
            return true;
        } else {
            return false;
        }
    }

}
