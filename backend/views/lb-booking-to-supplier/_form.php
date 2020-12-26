<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbBookingToSupplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-booking-to-supplier-form">

    <?php $form = ActiveForm::begin(); ?>
<?php
            $client_types = \common\models\LbSupplier::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pro[$client_type->id] = $client_type->name;
                }
            } else {
                $pro = [];
            }
            echo $form->field($model, 'supplier_id')->dropDownList($pro, ['prompt' => 'Choose Supplier', 'class' => 'form-control','onchange'=>'getDept(this.value);']);
            ?>
    <?= $form->field($model, 'booked_quantity_gallon')->textInput() ?>

    <?= $form->field($model, 'booked_quantity_litre')->textInput() ?>

    <?= $form->field($model, 'previous_balance_gallon')->textInput() ?>

    <?= $form->field($model, 'previous_balance_litre')->textInput() ?>

    <?= $form->field($model, 'current_balance_gallon')->textInput() ?>

    <?= $form->field($model, 'current_balance_litre')->textInput() ?>
    
 <?= $form->field($model, 'booking_date')->textInput(['id' => 'booking_date', 'class' => "date_book form-control"]) ?>

   
    <?= $form->field($model, 'price_per_gallon')->textInput() ?>

    <?= $form->field($model, 'price_per_litre')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
