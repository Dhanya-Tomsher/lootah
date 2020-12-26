<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbClientVehicleSwapRecords */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-client-vehicle-swap-records-form">

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
            $client_odps = \common\models\LbClientDepartments::find()->where(['status' => 1,])->all();
            if ($client_odps != NULL) {
                foreach ($client_odps as $client_odp) {
                    $proo[$client_odp->id] = $client_odp->department;
                }
            } else {
                $proo = [];
            }
            echo $form->field($model, 'old_department')->dropDownList($proo, ['prompt' => 'Choose Department', 'class' => 'form-control','id'=>'dept-list','onchange'=>'getVeh(this.value);']);
            ?>
    <?php
            $client_odvs = \common\models\LbClientVehicles::find()->where(['status' => 1,])->all();
            if ($client_odvs != NULL) {
                foreach ($client_odvs as $client_odv) {
                    $prov[$client_odv->id] = $client_odv->vehicle_number;
                }
            } else {
                $prov = [];
            }
            echo $form->field($model, 'old_vehicle')->dropDownList($prov, ['prompt' => 'Choose Old Vehicle', 'class' => 'form-control','id'=>'veh-list']);
            ?>
    
    <?php
            $client_ndvs = \common\models\LbClientVehicles::find()->where(['status' => 1,])->all();
            if ($client_ndvs != NULL) {
                foreach ($client_ndvs as $client_ndv) {
                    $prnv[$client_ndv->id] = $client_ndv->vehicle_number;
                }
            } else {
                $prnv = [];
            }
            echo $form->field($model, 'new_vehicle')->dropDownList($prnv, ['prompt' => 'Choose New Vehicle', 'class' => 'form-control','id'=>'allveh-list']);
            ?>
    
    
 <?= $form->field($model, 'date_replacement')->textInput(['id' => 'date_replacement', 'class' => "date_book form-control"]) ?>
    

    <?= $form->field($model, 'sort_order')->textInput() ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
   
    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(<<< EOT_JS_CODE

  $('#lbclientvehicleswaprecords-client_id').change(function(){
        var val = $('#lbclientvehicleswaprecords-client_id').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/lb-client-vehicle-swap-records/get-dept",
                data: {client_id: val}
             }).done(function (data) {
                    $('#dept-list').html(data);
             });
        
         $.ajax({
                type: "POST",
                url: baseurl + "/lb-client-vehicle-swap-records/get-allveh",
                data: {client_id: val}
             }).done(function (data) {
                    $('#allveh-list').html(data);
             });
        
  });
        
        $('#dept-list').change(function(){
        var dep = $('#dept-list').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/lb-client-vehicle-swap-records/get-veh",
                data: {dept_id: dep}
             }).done(function (data) {
                    $('#veh-list').html(data);
             });
  });
EOT_JS_CODE
);
?>
