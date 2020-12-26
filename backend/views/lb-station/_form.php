<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbStation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-station-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'station_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
    <?php
            $client_types = \common\models\LbStationOperator::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pro[$client_type->id] = $client_type->name;
                }
            } else {
                $pro = [];
            }
            echo $form->field($model, 'operator')->dropDownList($pro, ['prompt' => 'Choose Operator', 'class' => 'form-control']);
            ?>
    <?php
            $client_types = \common\models\LbSupervisor::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $prosu[$client_type->id] = $client_type->name;
                }
            } else {
                $prosu = [];
            }
            echo $form->field($model, 'supervisor')->dropDownList($prosu, ['prompt' => 'Choose Supervisor', 'class' => 'form-control']);
            ?>
        <?php
            $client_types = \common\models\LbAreaManager::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $prosua[$client_type->id] = $client_type->name;
                }
            } else {
                $prosua = [];
            }
            echo $form->field($model, 'areamanager')->dropDownList($prosua, ['prompt' => 'Choose Areamanager', 'class' => 'form-control']);
            ?>
    <?= $form->field($model, 'sort_order')->textInput() ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
