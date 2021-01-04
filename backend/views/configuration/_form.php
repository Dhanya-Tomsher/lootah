<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Configuration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuration-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'platform')->dropDownList(['APP' => 'App', 'WEB' => 'Web']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-2">
            <?= $form->field($model, 'dms_user_name')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-2">
            <?= $form->field($model, 'dms_password')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-2">
            <?= $form->field($model, 'dms_access_token')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-2">
            <?= $form->field($model, 'dms_token_last_updated_on')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
        </div>

    </div>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
