<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_gallon_litre".
 *
 * @property int $id
 * @property double $gallon
 * @property double $litre
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbGallonLitre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_gallon_litre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gallon', 'litre'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['gallon', 'litre'], 'required'],
            [['created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gallon' => 'Gallon',
            'litre' => 'Litre',
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
