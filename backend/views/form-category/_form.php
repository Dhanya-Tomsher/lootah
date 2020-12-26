<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FormCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <?= $form->field($model, 'category_en')->textInput(['maxlength' => true]) ?>


        </div>
        <div class="col-xs-12 col-sm-4">

            <?= $form->field($model, 'category_ar')->textInput(['maxlength' => true]) ?>

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
