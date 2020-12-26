<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbClientType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-client-type-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'type')->textInput() ?>

    
    <?= $form->field($model, 'sort_order')->textInput() ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
    
    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
