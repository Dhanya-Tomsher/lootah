<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'UUID') ?>

    <?= $form->field($model, 'transaction_no') ?>

    <?= $form->field($model, 'ReferenceId') ?>

    <?= $form->field($model, 'SequenceId') ?>

    <?= $form->field($model, 'DeviceId') ?>

    <?php // echo $form->field($model, 'Meter') ?>

    <?php // echo $form->field($model, 'SecondaryTag') ?>

    <?php // echo $form->field($model, 'Category') ?>

    <?php // echo $form->field($model, 'Operator') ?>

    <?php // echo $form->field($model, 'Asset') ?>

    <?php // echo $form->field($model, 'AccumulatorType') ?>

    <?php // echo $form->field($model, 'Sitecode') ?>

    <?php // echo $form->field($model, 'Project') ?>

    <?php // echo $form->field($model, 'PlateNo') ?>

    <?php // echo $form->field($model, 'Master') ?>

    <?php // echo $form->field($model, 'Accumulator') ?>

    <?php // echo $form->field($model, 'Volume') ?>

    <?php // echo $form->field($model, 'Allowance') ?>

    <?php // echo $form->field($model, 'Type') ?>

    <?php // echo $form->field($model, 'StartTime') ?>

    <?php // echo $form->field($model, 'EndTime') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'ServerTimestamp') ?>

    <?php // echo $form->field($model, 'UpdateTimestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
