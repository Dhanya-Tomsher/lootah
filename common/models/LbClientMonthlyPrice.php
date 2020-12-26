<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_client_monthly_price".
 *
 * @property int $id
 * @property int $client_id
 * @property double $govt_price
 * @property double $discount
 * @property double $customer_price
 * @property int $month
 * @property double $year
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_by_type
 * @property string $updated_by_type
 * @property string $sort_order
 * @property int $status
 */
class LbClientMonthlyPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_client_monthly_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'month', 'status'], 'integer'],
            [['govt_price', 'discount', 'customer_price', 'year'], 'number'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'govt_price' => 'Govt Price',
            'discount' => 'Discount',
            'customer_price' => 'Customer Price',
            'month' => 'Month',
            'year' => 'Year',
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
    
    public function getClient()
    {
        return $this->hasOne(LbClients::className(), ['id' => 'client_id']);
    }
}
