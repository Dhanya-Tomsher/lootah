<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_rating_category".
 *
 * @property int $id
 * @property string $category_en
 * @property string $category_ar
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class FormCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rating_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_en', 'category_ar', 'status'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['category_en', 'category_ar'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_en' => 'Category En',
            'category_ar' => 'Category Ar',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
