<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Dispenser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dispenser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>


    <?php
    $client_types = \common\models\LbStation::find()->where(['status' => 1])->all();
    if ($client_types != NULL) {
        foreach ($client_types as $client_type) {
            $pro[$client_type->id] = $client_type->station_name;
        }
    } else {
        $pro = [];
    }
    echo $form->field($model, 'station_id')->dropDownList($pro, ['prompt' => 'Choose Station', 'class' => 'form-control']);
    ?>

    <?= $form->field($model, 'order_by')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
