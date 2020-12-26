<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbSupervisor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-supervisor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?php
    
    
                                        if (!is_array($model->assigned_stations)) {
                                            $projects = explode(',', $model->assigned_stations);
                                        } else {
                                            $projects = $model->assigned_stations;
                                        }
                                                                                
            $agents = \common\models\LbStation::find()->where(['status' => 1])->all();
            if ($agents != NULL) {
                foreach ($agents as $agent) {
                    if (in_array($agent->id, $projects)) {                    
                        $age[$agent->id] = $agent->station_name; 
                        $sel[$agent->id] = array("selected"=>"selected");
                    }else{
                       $age[$agent->id] = $agent->station_name; 
                       $sel[$agent->id] = "";
                    }
                }
            } else {
                $age = [];
            }
            echo $form->field($model, 'assigned_stations')->dropDownList($age, ['multiple' => true, 'class' => 'form-control','options' => $sel]);
            ?>
            
    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>

<style>
    #lbsupervisor-assigned_stations{
    height: 163px ! important;
    }
    </style>
