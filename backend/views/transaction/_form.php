<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'UUID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transaction_no')->textInput() ?>

    <?= $form->field($model, 'ReferenceId')->textInput() ?>

    <?= $form->field($model, 'SequenceId')->textInput() ?>

    <?= $form->field($model, 'DeviceId')->textInput() ?>

    <?= $form->field($model, 'Meter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SecondaryTag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Operator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Asset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AccumulatorType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Sitecode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Project')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PlateNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Master')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Accumulator')->textInput() ?>

    <?= $form->field($model, 'Volume')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Allowance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'StartTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EndTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ServerTimestamp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UpdateTimestamp')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
