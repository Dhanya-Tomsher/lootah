<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AbrajEvents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="abraj-events-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($model, 'title')->textInput(['rows' => 6]) ?>

        </div>
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($model, 'title_ar')->textInput(['rows' => 6]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        </div>
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($model, 'description_ar')->textarea(['rows' => 6]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

        </div>
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'from_time')->textInput(['type' => 'time']) ?>

        </div>
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'status')->dropDownList([1 => 'Enable', 0 => 'Disable']) ?>

        </div>
    </div>







    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
