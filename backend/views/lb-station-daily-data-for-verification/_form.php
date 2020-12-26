<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbStationDailyDataForVerification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-station-daily-data-for-verification-form">

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
        <?= $form->field($model, 'date_entry')->textInput(['id' => 'date_entry', 'class' => "date_book form-control"]) ?>

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

    <?= $form->field($model, 'physical_stock')->textInput() ?>

    <?= $form->field($model, 'stock_by_calculation')->textInput() ?>

    <?= $form->field($model, 'stock_difference')->textInput() ?>

    <?php
            $client_types = \common\models\LbSupervisor::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $prosu[$client_type->id] = $client_type->name;
                }
            } else {
                $prosu = [];
            }
            echo $form->field($model, 'physica_data_entered_by')->dropDownList($prosu, ['prompt' => 'Choose Supervisor', 'class' => 'form-control','disabled'=>'true']);
            ?>
    <?= $form->field($model, 'closing_stock')->textInput() ?>

    <?= $form->field($model, 'sold_qty')->textInput() ?>

    <?= $form->field($model, 'cash_sales')->textInput() ?>

    <?= $form->field($model, 'card_sales')->textInput() ?>
    
    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
