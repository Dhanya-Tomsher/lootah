<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbBookingToSupplierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-booking-to-supplier-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'booked_quantity_gallon') ?>

    <?= $form->field($model, 'booked_quantity_litre') ?>

    <?= $form->field($model, 'previous_balance_gallon') ?>

    <?php // echo $form->field($model, 'previous_balance_litre') ?>

    <?php // echo $form->field($model, 'current_balance_gallon') ?>

    <?php // echo $form->field($model, 'current_balance_litre') ?>

    <?php // echo $form->field($model, 'booking_date') ?>

    <?php // echo $form->field($model, 'price_per_gallon') ?>

    <?php // echo $form->field($model, 'price_per_litre') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_by_type') ?>

    <?php // echo $form->field($model, 'updated_by_type') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
