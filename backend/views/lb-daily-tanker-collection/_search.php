<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbDailyTankerCollectionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-daily-tanker-collection-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tanker_id') ?>

    <?= $form->field($model, 'operator_id') ?>

    <?= $form->field($model, 'client_type') ?>

    <?= $form->field($model, 'vehicle_id') ?>

    <?php // echo $form->field($model, 'collection_type') ?>

    <?php // echo $form->field($model, 'quantity_gallon') ?>

    <?php // echo $form->field($model, 'quantity_litre') ?>

    <?php // echo $form->field($model, 'amount_litre') ?>

    <?php // echo $form->field($model, 'amount_gallon') ?>

    <?php // echo $form->field($model, 'supervisor_approval_status') ?>

    <?php // echo $form->field($model, 'supervisor_approved_by') ?>

    <?php // echo $form->field($model, 'area_manager_approval_status') ?>

    <?php // echo $form->field($model, 'area_manager_approved_by') ?>

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
