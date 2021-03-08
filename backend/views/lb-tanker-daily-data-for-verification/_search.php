<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankerDailyDataForVerificationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-tanker-daily-data-for-verification-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tanker_id') ?>

    <?= $form->field($model, 'date_entry') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'physical_stock_gallon') ?>

    <?php // echo $form->field($model, 'stock_by_calculation_gallon') ?>

    <?php // echo $form->field($model, 'physical_stock') ?>

    <?php // echo $form->field($model, 'stock_by_calculation') ?>

    <?php // echo $form->field($model, 'stock_difference') ?>

    <?php // echo $form->field($model, 'closing_stock') ?>

    <?php // echo $form->field($model, 'physical_stock_litre') ?>

    <?php // echo $form->field($model, 'stock_by_calculation_litre') ?>

    <?php // echo $form->field($model, 'stock_difference_gallon') ?>

    <?php // echo $form->field($model, 'stock_difference_litre') ?>

    <?php // echo $form->field($model, 'physica_data_entered_by') ?>

    <?php // echo $form->field($model, 'closing_stock_gallon') ?>

    <?php // echo $form->field($model, 'closing_stock_litre') ?>

    <?php // echo $form->field($model, 'sold_qty') ?>

    <?php // echo $form->field($model, 'cash_sales') ?>

    <?php // echo $form->field($model, 'card_sales') ?>

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
