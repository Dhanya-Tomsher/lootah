<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbClientDepartments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-client-departments-form">

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
            echo $form->field($model, 'client_id')->dropDownList($pro, ['prompt' => 'Choose Client', 'class' => 'form-control']);
            ?>

    <?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?>

   

    <?= $form->field($model, 'sort_order')->textInput() ?>

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
