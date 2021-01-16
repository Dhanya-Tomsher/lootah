<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>

    <?php //form->field($model, 'UUID') ?>
    <div class="col-xs-12 col-sm-3">
        <?php
        echo $form->field($model, 'station_id')->dropDownList(ArrayHelper::map(\common\models\LbStation::find()->all(), 'id', 'station_name'), ['prompt' => 'Choos a Station', 'class' => 'form-control']);
        ?>

    </div>
    <div class="col-xs-12 col-sm-3">
        <?php
        echo $form->field($model, 'dispenser_id')->dropDownList(ArrayHelper::map(\common\models\Dispenser::find()->all(), 'id', 'label'), ['prompt' => 'Choos a Dispenser', 'class' => 'form-control']);
        ?>

    </div>

    <div class="col-xs-12 col-sm-3">
        <?php
        echo $form->field($model, 'nozle_id')->dropDownList(ArrayHelper::map(\common\models\Nozzle::find()->all(), 'id', 'label'), ['prompt' => 'Choos a Nozzle', 'class' => 'form-control']);
        ?>

    </div>
    <div class="col-xs-12 col-sm-3">
        <?php
        $payment_method["Lootah-T"] = 'Tanker';
        $payment_method["Lootah-S"] = 'Station';
        ?>

        <?php
        echo $form->field($model, 'device_type')->dropDownList($payment_method, ['prompt' => 'Choos a Device Type', 'class' => 'form-control']);
        ?>

    </div>
    <div class="col-xs-12 col-sm-3">
        <?= $form->field($model, 'transaction_no') ?>

    </div>
    <div class="col-xs-12 col-sm-3">
        <?= $form->field($model, 'date_from') ?>

    </div>
    <div class="col-xs-12 col-sm-3">
        <?= $form->field($model, 'date_to') ?>

    </div>
    <?php // $form->field($model, 'transaction_no') ?>

    <?php // $form->field($model, 'ReferenceId') ?>

    <?php // $form->field($model, 'SequenceId') ?>

    <?php // $form->field($model, 'DeviceId') ?>

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

    <?php // echo $form->field($model, 'UpdateTimestamp')  ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
