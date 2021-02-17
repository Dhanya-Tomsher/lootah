<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbGeneralSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-general-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'govt_price')->textInput(['onkeyup'=>'validateForm()']) ?>

    <?= $form->field($model, 'discount')->textInput(['onkeyup'=>'validateForm1()']) ?>

    <?= $form->field($model, 'customer_price')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'month')->dropDownList(['empty'=>'Select Month','1' => 'January', '2' => 'February','3' => 'March', '4' => 'April','5' => 'May', '6' => 'June','7' => 'July', '8' => 'August','9' => 'September', '10' => 'October','11' => 'November', '12' => 'December']) ?>
    <?php
$y=date('Y');
$y1=date("Y", strtotime("+1 year"));
?>
    <?= $form->field($model, 'year')->dropDownList(['empty'=>'Select Year',$y => $y, $y1 => $y1]) ?>
    <?= $form->field($model, 'sort_order')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<script>
 function validateForm(){
  var gov = document.getElementById("lbgeneralsettings-govt_price").value;
  var dis = document.getElementById("lbgeneralsettings-discount").value;
  document.getElementById("lbgeneralsettings-customer_price").value= gov - dis;
  }
  function validateForm1(){
  var gov = document.getElementById("lbgeneralsettings-govt_price").value;
  var dis = document.getElementById("lbgeneralsettings-discount").value;
  document.getElementById("lbgeneralsettings-customer_price").value= gov - dis;
  }
</script>