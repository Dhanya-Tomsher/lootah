<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CrmManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'module_name')->textInput() ?>
    <?= $form->field($model, 'module_key')->textInput() ?>
    <?= $form->field($model, 'module_function')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList([1 => 'Enable', 0 => 'Disable']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
