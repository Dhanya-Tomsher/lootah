<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Nozzle */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$dispenser_list = [];

if (!$model->isNewRecord) {
    $getdispenser = \common\models\Dispenser::find()->where(['status' => 1])->all();
    if ($getdispenser != NULL) {
        foreach ($getdispenser as $getdispens) {
            $dispenser_list[$getdispens->id] = $getdispens->label;
        }
    } else {
        $dispenser_list = [];
    }
}
?>
<div class="nozzle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
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



    <?php
    echo $form->field($model, 'dispenser_id')->dropDownList($dispenser_list, ['prompt' => 'Choose a Dispenser', 'class' => 'form-control']);
    ?>

    <?= $form->field($model, 'order_by')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
