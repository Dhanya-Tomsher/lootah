<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "lb_booking_to_supplier".
 *
 * @property int $id
 * @property int $supplier_id
 * @property double $booked_quantity_gallon
 * @property double $booked_quantity_litre
 * @property double $previous_balance_gallon
 * @property double $previous_balance_litre
 * @property double $current_balance_gallon
 * @property double $current_balance_litre
 * @property string $booking_date
 * @property double $price_per_gallon
 * @property double $price_per_litre
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_by_type
 * @property int $updated_by_type
 * @property int $sort_order
 * @property int $status
 */
class LbBookingToSupplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_booking_to_supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id', 'created_by', 'updated_by', 'created_by_type', 'updated_by_type', 'sort_order', 'status'], 'integer'],
            [['booked_quantity_gallon', 'booked_quantity_litre', 'previous_balance_gallon', 'previous_balance_litre', 'current_balance_gallon', 'current_balance_litre', 'price_per_gallon', 'price_per_litre'], 'number'],
            [['booking_date', 'created_at', 'updated_at'], 'safe'],
            //[['price_per_litre', 'created_at'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'booked_quantity_gallon' => 'Booked Quantity Gallon',
            'booked_quantity_litre' => 'Booked Quantity Litre',
            'previous_balance_gallon' => 'Previous Balance Gallon',
            'previous_balance_litre' => 'Previous Balance Litre',
            'current_balance_gallon' => 'Current Balance Gallon',
            'current_balance_litre' => 'Current Balance Litre',
            'booking_date' => 'Booking Date',
            'price_per_gallon' => 'Price Per Gallon',
            'price_per_litre' => 'Price Per Litre',
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
    public function getSupplier()
    {
        return $this->hasOne(LbSupplier::className(), ['id' => 'supplier_id']);
    }
    public function uploadFileLPO($file, $name, $id){

        $targetFolder = \yii::$app->basePath . '/../uploads/lpo/' . $id . '/';
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
    public function search($params) {
        $query = LbBookingToSupplier::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->FilterWhere([
            'transaction_type' => 1,
        ]);
        
         if (isset($this->booking_date) && $this->booking_date != "") {
            $date_from = date('Y-m-d', strtotime($this->booking_date));
            //echo $date_from;
            $query->andWhere("booking_date >=  '" . $date_from . "'");
        }
        if (isset($this->created_at) && $this->created_at != "") {
            $date_to = date('Y-m-d', strtotime($this->created_at));
            // echo $date_to;
            //echo "...";
            $query->andWhere("booking_date <=  '" . $date_to . "'");
            //exit;
        }
        
    
        $query->andFilterWhere([
            'supplier_id' => $this->supplier_id,
        ]);

        return $dataProvider;
    }    
    public function searchbooking($params) {
        $query = LbBookingToSupplier::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->FilterWhere([
            'transaction_type' => 1,
        ]);
        
         if (isset($this->booking_date) && $this->booking_date != "") {
            $date_from = date('Y-m-d', strtotime($this->booking_date));
            //echo $date_from;
            $query->andWhere("booking_date >=  '" . $date_from . "'");
        }
        if (isset($this->created_at) && $this->created_at != "") {
            $date_to = date('Y-m-d', strtotime($this->created_at));
            // echo $date_to;
            //echo "...";
            $query->andWhere("booking_date <=  '" . $date_to . "'");
            //exit;
        }
        
    
        $query->andFilterWhere([
            'supplier_id' => $this->supplier_id,
        ]);

        return $dataProvider;
    }
}
