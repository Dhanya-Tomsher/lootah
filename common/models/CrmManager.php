<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_crm_manager".
 *
 * @property int $id
 * @property int $module_name
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $update_by 0-cms,1-crm
 */
class CrmManager extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tbl_crm_manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['module_name', 'status', 'update_by', 'module_key'], 'required'],
            [['status', 'update_by'], 'integer'],
            [['created_at', 'updated_at', 'can_name', 'module_function', 'params'], 'safe'],
            [['can_name', 'module_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'module_name' => 'Module Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'update_by' => 'Last Update By',
        ];
    }

}
