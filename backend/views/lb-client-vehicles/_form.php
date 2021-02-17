<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbClientVehicles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-client-vehicles-form">

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
            echo $form->field($model, 'client_id')->dropDownList($pro, ['prompt' => 'Choose Client', 'class' => 'form-control','onchange'=>'getDept(this.value);']);
            ?>

    <?php
            $de_types = \common\models\LbClientDepartments::find()->where(['status' => 1])->all();
            if ($de_types != NULL) {
                foreach ($de_types as $de_type) {
                    $prode[$de_type->id] = $de_type->department;
                }
            } else {
                $prode = [];
            }
            echo $form->field($model, 'department_id')->dropDownList($prode, ['prompt' => 'Choose Department', 'class' => 'form-control','id'=>'dept-list']);
            ?>
    <?php
            $ve_types = \common\models\LbVehicleType::find()->where(['status' => 1])->all();
            if ($ve_types != NULL) {
                foreach ($ve_types as $ve_type) {
                    $prove[$ve_type->id] = $ve_type->vehicle_type;
                }
            } else {
                $prove = [];
            }
            echo $form->field($model, 'vehicle_type')->dropDownList($prove, ['prompt' => 'Choose Vehicle Type', 'class' => 'form-control']);
            ?>
    
    <?= $form->field($model, 'vehicle_number')->textInput(['maxlength' => true]) ?>
    
    <!--<?= $form->field($model, 'sort_order')->textInput() ?>-->

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(<<< EOT_JS_CODE

  $('#lbclientvehicles-client_id').change(function(){
        var val = $('#lbclientvehicles-client_id').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/lb-client-vehicles/get-dept",
                data: {client_id: val}
             }).done(function (data) {
                    $('#dept-list').html(data);
             });
  });
EOT_JS_CODE
);
?>

