<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model common\models\LbClients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-clients-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

 <?php
    echo
    $form->field($model, 'profile_image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'profile_image/*'],
        'pluginOptions' => ['previewFileType' => 'any',
            'allowedFileExtensions' => ['png', 'jpeg', 'jpg'],
            'showUpload' => false
        ],
    ]);
    ?>
   <div class="form-group">
        <div id="imagePriview">
            <?php
            if (isset($model->id) && $model->id > 0 && isset($model->profile_image) && $model->profile_image !== "") {
                $folder = Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/';

                $imgPath = ((yii\helpers\Url::base())) . '/../uploads/clients/' . $model->id . '/' . $model->profile_image;
            } else {
                $imgPath = ((yii\helpers\Url::base())) . '/../backend/web/images/noimage.png';
            }

            echo '<img width="125" style="border: 2px solid #d2d2d2;" src="' . $imgPath . '" />';
            ?>
        </div>

    </div>
    <br/>
    <br/>
    
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'emirate')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contactperson_position')->textInput(['maxlength' => true]) ?>
     
    <!--<?= $form->field($model, 'current_month_govt_price')->textInput() ?>-->

    <?= $form->field($model, 'discount')->textInput() ?>

    <!--<?= $form->field($model, 'current_month_display_price')->textInput() ?>-->

    <!--<?= $form->field($model, 'payment_terms')->textarea(['rows' => 6]) ?>-->

    <!--<?= $form->field($model, 'contract_start')->textInput() ?>-->

    <!--<?= $form->field($model, 'contract_expiry')->textInput() ?> -->   

    <!--<?= $form->field($model, 'sort_order')->textInput() ?>-->

     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
