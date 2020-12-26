<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbStationOperator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-station-operator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
   <?php
            $client_types = \common\models\LbStation::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pros[$client_type->id] = $client_type->station_name;
                }
            } else {
                $pros = [];
            }
            echo $form->field($model, 'station')->dropDownList($pros, ['prompt' => 'Station', 'class' => 'form-control','disabled'=>'true']);
            ?>
    <?= $form->field($model, 'sort_order')->textInput() ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
