<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_clients".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $profile_image
 * @property double $current_month_govt_price
 * @property double $discount
 * @property double $current_month_display_price
 * @property string $payment_terms
 * @property string $contract_start
 * @property string $contract_expiry
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbClients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['current_month_govt_price', 'discount', 'current_month_display_price'], 'number'],
            [['payment_terms'], 'string'],
            [['contract_start', 'contract_expiry', 'created_at'], 'safe'],
            [['created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['name', 'email', 'password', 'profile_image', 'updated_at'], 'string', 'max' => 45],
        ];
    }

    public function uploadFile($file, $name, $id){

        $targetFolder = \yii::$app->basePath . '/../uploads/clients/' . $id . '/';
        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }
        if ($file->saveAs($targetFolder . $name . '.' . $file->extension)) {
            return true;
        }
        else {
            return false;
        }
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
            'password' => 'Password',
            'profile_image' => 'Profile Image',
            'current_month_govt_price' => 'Current Month Govt Price',
            'discount' => 'Discount',
            'current_month_display_price' => 'Current Month Display Price',
            'payment_terms' => 'Payment Terms',
            'contract_start' => 'Contract Start',
            'contract_expiry' => 'Contract Expiry',
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
