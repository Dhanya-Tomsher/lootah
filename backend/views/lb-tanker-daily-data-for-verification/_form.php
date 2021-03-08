<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankerDailyDataForVerification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-tanker-daily-data-for-verification-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'tanker_id')->textInput() ?>

    <?= $form->field($model, 'date_entry')->textInput() ?>

    <?= $form->field($model, 'unit')->textInput() ?>

    <?= $form->field($model, 'physical_stock_gallon')->textInput() ?>

    <?= $form->field($model, 'stock_by_calculation_gallon')->textInput() ?>

    <?= $form->field($model, 'physical_stock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock_by_calculation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock_difference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'closing_stock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'physical_stock_litre')->textInput() ?>

    <?= $form->field($model, 'stock_by_calculation_litre')->textInput() ?>

    <?= $form->field($model, 'stock_difference_gallon')->textInput() ?>

    <?= $form->field($model, 'stock_difference_litre')->textInput() ?>

    <?= $form->field($model, 'physica_data_entered_by')->textInput() ?>

    <?= $form->field($model, 'closing_stock_gallon')->textInput() ?>

    <?= $form->field($model, 'closing_stock_litre')->textInput() ?>

    <?= $form->field($model, 'sold_qty')->textInput() ?>

    <?= $form->field($model, 'cash_sales')->textInput() ?>

    <?= $form->field($model, 'card_sales')->textInput() ?>

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
