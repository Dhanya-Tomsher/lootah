<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbStationStock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-station-stock-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'station_id')->textInput() ?>

    <?= $form->field($model, 'opening_stock_litre')->textInput() ?>

    <?= $form->field($model, 'opening_stock_gallon')->textInput() ?>

    <?= $form->field($model, 'supplier_purchase_litre')->textInput() ?>

    <?= $form->field($model, 'supplier_purchase_gallon')->textInput() ?>

    <?= $form->field($model, 'tanker_load_litre')->textInput() ?>

    <?= $form->field($model, 'tanker_load_gallon')->textInput() ?>

    <?= $form->field($model, 'tanker_unload_litre')->textInput() ?>

    <?= $form->field($model, 'tanker_unload_gallon')->textInput() ?>

    <?= $form->field($model, 'station_sale_litre')->textInput() ?>

    <?= $form->field($model, 'station_sale_gallon')->textInput() ?>

    <?= $form->field($model, 'total_intake_litre')->textInput() ?>

    <?= $form->field($model, 'total_intake_gallon')->textInput() ?>

    <?= $form->field($model, 'total_out_litre')->textInput() ?>

    <?= $form->field($model, 'total_out_gallon')->textInput() ?>

    <?= $form->field($model, 'stock_in_dispenser_litre')->textInput() ?>

    <?= $form->field($model, 'stock_in_dispenser_gallon')->textInput() ?>

    <?= $form->field($model, 'date_entry')->textInput() ?>

    <?= $form->field($model, 'day_entry')->textInput() ?>

    <?= $form->field($model, 'month_entry')->textInput() ?>

    <?= $form->field($model, 'year_entry')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_by_type')->textInput() ?>

    <?= $form->field($model, 'updated_by_type')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
