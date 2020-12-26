<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbDailyStationCollectionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-daily-station-collection-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'station_id') ?>

    <?= $form->field($model, 'operator_id') ?>

    <?= $form->field($model, 'nozzle') ?>

    <?= $form->field($model, 'client_type') ?>

    <?php // echo $form->field($model, 'client_id') ?>

    <?php // echo $form->field($model, 'vehicle_id') ?>

    <?php // echo $form->field($model, 'vehicle_number') ?>

    <?php // echo $form->field($model, 'odometer_reading') ?>

    <?php // echo $form->field($model, 'collection_type') ?>

    <?php // echo $form->field($model, 'quantity_gallon') ?>

    <?php // echo $form->field($model, 'quantity_litre') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'opening_stock') ?>

    <?php // echo $form->field($model, 'closing_stock') ?>

    <?php // echo $form->field($model, 'edited_by') ?>

    <?php // echo $form->field($model, 'description_for_edit') ?>

    <?php // echo $form->field($model, 'edit_approval_status') ?>

    <?php // echo $form->field($model, 'edit_approved_by') ?>

    <?php // echo $form->field($model, 'edit_approval_comments') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_by_type') ?>

    <?php // echo $form->field($model, 'updated_by_type') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'supervisor_verification_status') ?>

    <?php // echo $form->field($model, 'supervisor_verified_by') ?>

    <?php // echo $form->field($model, 'area_manager_verification_status') ?>

    <?php // echo $form->field($model, 'area_manager_verified_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
