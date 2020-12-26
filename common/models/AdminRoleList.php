<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_admin_role_list".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $status
 * @property string $created_at
 * @property string $update_at
 */
class AdminRoleList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_admin_role_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'status'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'update_at'], 'safe'],
            [['name', 'value'], 'string', 'max' => 50],
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
            'value' => 'Value',
            'status' => 'Status',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }
}
