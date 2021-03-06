<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LbClientsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-clients-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'profile_image') ?>

    <?php // echo $form->field($model, 'current_month_govt_price') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'current_month_display_price') ?>

    <?php // echo $form->field($model, 'payment_terms') ?>

    <?php // echo $form->field($model, 'contract_start') ?>

    <?php // echo $form->field($model, 'contract_expiry') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_by_type') ?>

    <?php // echo $form->field($model, 'updated_by_type') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
