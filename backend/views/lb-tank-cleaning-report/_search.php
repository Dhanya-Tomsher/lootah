<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankCleaningReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-tank-cleaning-report-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'station_id') ?>

    <?= $form->field($model, 'date_cleaning') ?>

    <?= $form->field($model, 'next_date_cleaning') ?>

    <?= $form->field($model, 'tank_capacity_gallon') ?>

    <?php // echo $form->field($model, 'supervisor_id') ?>

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
