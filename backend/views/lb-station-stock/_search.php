<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbStationStockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-station-stock-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'station_id') ?>

    <?= $form->field($model, 'opening_stock_litre') ?>

    <?= $form->field($model, 'opening_stock_gallon') ?>

    <?= $form->field($model, 'supplier_purchase_litre') ?>

    <?php // echo $form->field($model, 'supplier_purchase_gallon') ?>

    <?php // echo $form->field($model, 'tanker_load_litre') ?>

    <?php // echo $form->field($model, 'tanker_load_gallon') ?>

    <?php // echo $form->field($model, 'tanker_unload_litre') ?>

    <?php // echo $form->field($model, 'tanker_unload_gallon') ?>

    <?php // echo $form->field($model, 'station_sale_litre') ?>

    <?php // echo $form->field($model, 'station_sale_gallon') ?>

    <?php // echo $form->field($model, 'total_intake_litre') ?>

    <?php // echo $form->field($model, 'total_intake_gallon') ?>

    <?php // echo $form->field($model, 'total_out_litre') ?>

    <?php // echo $form->field($model, 'total_out_gallon') ?>

    <?php // echo $form->field($model, 'stock_in_dispenser_litre') ?>

    <?php // echo $form->field($model, 'stock_in_dispenser_gallon') ?>

    <?php // echo $form->field($model, 'date_entry') ?>

    <?php // echo $form->field($model, 'day_entry') ?>

    <?php // echo $form->field($model, 'month_entry') ?>

    <?php // echo $form->field($model, 'year_entry') ?>

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
