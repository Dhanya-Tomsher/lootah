<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankCleaningReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-tank-cleaning-report-form">

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
<?= $form->field($model, 'date_cleaning')->textInput(['id' => 'date_cleaning', 'class' => "date_book form-control"]) ?>
<?= $form->field($model, 'next_date_cleaning')->textInput(['id' => 'next_date_cleaning', 'class' => "date_book form-control"]) ?>

    <?= $form->field($model, 'tank_capacity_gallon')->textInput() ?>
<?php
            $client_typesp = \common\models\LbPhysicalQuantityUnit::find()->where(['status' => 1])->all();
            if ($client_typesp != NULL) {
                foreach ($client_typesp as $client_typep) {
                    $prosp[$client_typep->id] = $client_typep->unit;
                }
            } else {
                $prosp = [];
            }
            echo $form->field($model, 'unit')->dropDownList($prosp, ['prompt' => 'Choose Unit', 'class' => 'form-control']);
            ?>
     <?php
            $client_types = \common\models\LbSupervisor::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pros[$client_type->id] = $client_type->name;
                }
            } else {
                $pros = [];
            }
            echo $form->field($model, 'supervisor_id')->dropDownList($pros, ['prompt' => 'Choose Supervisor', 'class' => 'form-control']);
            ?>
     <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
    
    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
