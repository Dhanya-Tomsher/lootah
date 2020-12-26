<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbDailyTankerCollection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-daily-tanker-collection-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
            $client_types = \common\models\LbTanker::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pro[$client_type->id] = $client_type->tanker_number;
                }
            } else {
                $pro = [];
            }
            echo $form->field($model, 'tanker_id')->dropDownList($pro, ['prompt' => 'Choose Tanker', 'class' => 'form-control']);
            ?>
    <?php
            $client_types = \common\models\LbTankerOperator::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $prop[$client_type->id] = $client_type->name;
                }
            } else {
                $prop = [];
            }
            echo $form->field($model, 'operator_id')->dropDownList($prop, ['prompt' => 'Choose Tanker Operator', 'class' => 'form-control']);
            ?>
    
    
    <?= $form->field($model, 'client_type')->dropDownList(['1' => 'Contractual', '2' => 'Walkin Client']) ?>
    <?php
            $client_typesc = \common\models\LbClients::find()->where(['status' => 1])->all();
            if ($client_typesc != NULL) {
                foreach ($client_typesc as $client_typec) {
                    $propc[$client_typec->id] = $client_typec->name;
                }
            } else {
                $propc = [];
            }
            echo $form->field($model, 'client_id')->dropDownList($propc, ['prompt' => 'Choose Client', 'class' => 'form-control']);
            ?>

    <?php
            $client_typescv = \common\models\LbClientVehicles::find()->where(['status' => 1])->all();
            if ($client_typescv != NULL) {
                foreach ($client_typescv as $client_typecv) {
                    $propcv[$client_typecv->id] = $client_typecv->vehicle_number;
                }
            } else {
                $propcv = [];
            }
            echo $form->field($model, 'vehicle_id')->dropDownList($propcv, ['prompt' => 'Choose Vehicle', 'class' => 'form-control']);
            ?>
<?= $form->field($model, 'vehicle_number')->textInput() ?>

    <?= $form->field($model, 'odometer_reading')->textInput() ?>
    <?= $form->field($model, 'collection_type')->textInput() ?>

    <?= $form->field($model, 'quantity_gallon')->textInput() ?>

    <?= $form->field($model, 'quantity_litre')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

<?= $form->field($model, 'purchase_date')->textInput(['id' => 'purchase_date', 'class' => "date_book form-control"]) ?>
    <?= $form->field($model, 'supervisor_approval_status')->dropDownList(['1' => 'Verified', '0' => 'Not Verified']) ?>
    
    <?php
            $client_types = \common\models\LbSupervisor::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $prosu[$client_type->id] = $client_type->name;
                }
            } else {
                $prosu = [];
            }
            echo $form->field($model, 'supervisor_approved_by')->dropDownList($prosu, ['prompt' => 'Choose Supervisor', 'class' => 'form-control']);
            ?>
    <?= $form->field($model, 'area_manager_approval_status')->dropDownList(['1' => 'Verified', '0' => 'Not Verified']) ?>
    <?php
            $client_typesea = \common\models\LbAreaManager::find()->where(['status' => 1])->all();
            if ($client_typesea != NULL) {
                foreach ($client_typesea as $client_typeea) {
                    $prosuea[$client_typeea->id] = $client_typeea->name;
                }
            } else {
                $prosuea = [];
            }
            echo $form->field($model, 'area_manager_approved_by')->dropDownList($prosuea, ['prompt' => 'Choose Area Manager', 'class' => 'form-control']);
            ?>
    
    <?= $form->field($model, 'sort_order')->textInput() ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
