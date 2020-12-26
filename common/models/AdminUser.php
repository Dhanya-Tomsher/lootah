<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_user".
 *
 * @property int $id
 * @property int $admin_post_id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $created_on
 * @property string $updated_on
 * @property int $created_user
 * @property int $updated_user
 * @property int $status
 */
class AdminUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_post_id', 'username', 'password', 'name', 'email', 'phone', 'created_on', 'created_user', 'updated_user', 'status'], 'required'],
            [['admin_post_id', 'created_user', 'updated_user', 'status'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['username', 'name'], 'string', 'max' => 250],
            [['password'], 'string', 'max' => 254],
            [['email'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_post_id' => 'Admin Post ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'created_user' => 'Created User',
            'updated_user' => 'Updated User',
            'status' => 'Status',
        ];
    }
}
