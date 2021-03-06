<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbOperatorTankerAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-operator-tanker-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

        <?php
            $client_types = \common\models\LbTankerOperator::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pro[$client_type->id] = $client_type->name;
                }
            } else {
                $pro = [];
            }
            echo $form->field($model, 'operator_id')->dropDownList($pro, ['prompt' => 'Choose Operator', 'class' => 'form-control']);
            ?>
        <?php
            $client_types = \common\models\LbTanker::find()->where(['status' => 1])->all();
            if ($client_types != NULL) {
                foreach ($client_types as $client_type) {
                    $pros[$client_type->id] = $client_type->tanker_number;
                }
            } else {
                $pros = [];
            }
            echo $form->field($model, 'tanker_id')->dropDownList($pros, ['prompt' => 'Choose Tanker', 'class' => 'form-control']);
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
            echo $form->field($model, 'assigned_by')->dropDownList($prosu, ['prompt' => 'Choose Supervisor', 'class' => 'form-control']);
            ?>

            <?= $form->field($model, 'date_assignment')->textInput(['id' => 'date_assignment', 'class' => "date_book form-control"]) ?>           

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
