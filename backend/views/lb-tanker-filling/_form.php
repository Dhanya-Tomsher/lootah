<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankerFilling */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-tanker-filling-form">

    <?php $form = ActiveForm::begin(); ?>       

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
    
    <?= $form->field($model, 'tanker_id')->dropDownList(['prompt' => 'Choose Tanker']) ?>

    <?php
            $t_types = \common\models\LbStationOperator::find()->where(['status' => 1])->all();
            if ($t_types != NULL) {
                foreach ($t_types as $t_type) {
                    $prot[$t_type->id] = $t_type->name;
                }
            } else {
                $prot = [];
            }
            echo $form->field($model, 'station_operator')->dropDownList($prot, ['prompt' => 'Choose Station Operator', 'class' => 'form-control']);
    ?>
    <?php
            $tt_types = \common\models\LbTankerOperator::find()->where(['status' => 1])->all();
            if ($tt_types != NULL) {
                foreach ($tt_types as $tt_type) {
                    $prott[$tt_type->id] = $tt_type->name;
                }
            } else {
                $prott = [];
            }
            echo $form->field($model, 'tanker_operator')->dropDownList($prott, ['prompt' => 'Choose Tanker Operator', 'class' => 'form-control']);
    ?>

    <?= $form->field($model, 'quantity_litre')->textInput() ?>

    <?= $form->field($model, 'quantity_gallon')->textInput() ?>

    <?= $form->field($model, 'date_entry')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>            
<script>
        $('#lbtankerfilling-station_id').change(function(){
        var dep = $('#lbtankerfilling-station_id').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/lb-tanker-filling/get-tanker",
                data: {dept_id: dep}
             }).done(function (data) {
                    $('#lbtankerfilling-tanker_id').html(data);
             });
  });
</script>
