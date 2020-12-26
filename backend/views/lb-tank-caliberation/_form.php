<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankCaliberation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-tank-caliberation-form">

    <?php $form = ActiveForm::begin(); ?>

        <?php
            $client_types = \common\models\LbStation::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pros[$client_type->id] = $client_type->station_name;
                }
            } else {
                $pros = [];
            }
            echo $form->field($model, 'station_id')->dropDownList($pros, ['prompt' => 'Choose Station', 'class' => 'form-control']);
            ?>

    <?= $form->field($model, 'physical_quantity')->textInput(['maxlength' => true]) ?>
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


    <?= $form->field($model, 'sort_order')->textInput() ?>

      <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
