<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbPhysicalQuantityUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-physical-quantity-unit-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'sort_order')->textInput() ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
