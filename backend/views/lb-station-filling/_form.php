<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbStationFilling */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-station-filling-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'station_id')->textInput() ?>

    <?= $form->field($model, 'filling_by')->textInput() ?>

    <?= $form->field($model, 'operator_id')->textInput() ?>

    <?= $form->field($model, 'quantity_litre')->textInput() ?>

    <?= $form->field($model, 'quantity_gallon')->textInput() ?>

    <?= $form->field($model, 'supplier_id')->textInput() ?>

    <?= $form->field($model, 'tanker_id')->textInput() ?>

    <?= $form->field($model, 'tanker_operator_id')->textInput() ?>

    <?= $form->field($model, 'date_entry')->textInput() ?>

    <?= $form->field($model, 'do_number')->textInput() ?>

    <?= $form->field($model, 'do_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_manager_approval_status')->textInput() ?>

    <?= $form->field($model, 'area_manager_approved_by')->textInput() ?>

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
