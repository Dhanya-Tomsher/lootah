<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_furnished_status".
 *
 * @property int $id
 * @property string $title
 * @property string $label_en
 * @property string $label_ar
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class FurnishedStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_furnished_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'label_en', 'label_ar', 'status'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'label_en', 'label_ar'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'label_en' => 'Label En',
            'label_ar' => 'Label Ar',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
