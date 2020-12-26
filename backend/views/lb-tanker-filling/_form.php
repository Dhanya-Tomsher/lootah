<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankerFilling */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-tanker-filling-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'tanker_id')->textInput() ?>

    <?= $form->field($model, 'station_id')->textInput() ?>

    <?= $form->field($model, 'tanker_operator')->textInput() ?>

    <?= $form->field($model, 'station_operator')->textInput() ?>

    <?= $form->field($model, 'quantity_litre')->textInput() ?>

    <?= $form->field($model, 'quantity_gallon')->textInput() ?>

    <?= $form->field($model, 'date_entry')->textInput() ?>

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
