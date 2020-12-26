<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_admin_role_category".
 *
 * @property int $id
 * @property int $role_id
 * @property string $access_location
 * @property int $status 1=Enable,0=Desable
 * @property string $created_at
 * @property string $updated_at
 */
class AdminRoleCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_admin_role_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'access_location', 'status'], 'required'],
            [['role_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['access_location'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'access_location' => 'Access Location',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
