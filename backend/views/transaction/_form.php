<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'UUID')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'transaction_no')->textInput() ?>

    <?php // $form->field($model, 'ReferenceId')->textInput() ?>

    <?php // $form->field($model, 'SequenceId')->textInput() ?>

    <?php // $form->field($model, 'DeviceId')->textInput() ?>

    <?php // $form->field($model, 'Meter')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'SecondaryTag')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Category')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Operator')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Asset')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'AccumulatorType')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Sitecode')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Project')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PlateNo')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Master')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Accumulator')->textInput() ?>

    <?= $form->field($model, 'Volume')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Allowance')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Type')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'StartTime')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'EndTime')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'Status')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'ServerTimestamp')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'UpdateTimestamp')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
