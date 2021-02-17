<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbClientMonthlyPrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-client-monthly-price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
            $client_types = \common\models\LbClients::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pro[$client_type->id] = $client_type->name;
                }
            } else {
                $pro = [];
            }
            echo $form->field($model, 'client_id')->dropDownList($pro, ['prompt' => 'Choose Client', 'class' => 'form-control']);
            ?>

    <?= $form->field($model, 'govt_price')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'customer_price')->textInput() ?>

   <?= $form->field($model, 'month')->dropDownList(['1' => 'January', '2' => 'February','3' => 'March', '4' => 'April','5' => 'May', '6' => 'June','7' => 'July', '8' => 'August','9' => 'September', '10' => 'October','11' => 'November', '12' => 'December']) ?>
    <?php
$y=date('Y');
$y1=date("Y", strtotime("+1 year"));
?>
    <?= $form->field($model, 'year')->dropDownList([$y => $y, $y1 => $y1]) ?>


    <!--<?= $form->field($model, 'sort_order')->textInput(['maxlength' => true]) ?>-->

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
