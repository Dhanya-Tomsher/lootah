<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model common\models\LbAreaManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lb-area-manager-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php
    echo
    $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => ['previewFileType' => 'any',
            'allowedFileExtensions' => ['png', 'jpeg', 'jpg'],
            'showUpload' => false
        ],
    ]);
    ?>
    <div class="form-group">
        <div id="imagePriview">
            <?php
            if (isset($model->id) && $model->id > 0 && isset($model->image) && $model->image !== "") {
                $folder = Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/';

                $imgPath = ((yii\helpers\Url::base())) . '/../uploads/areamanager/' . $model->id . '/' . $model->image;
            } else {
                $imgPath = ((yii\helpers\Url::base())) . '/../backend/web/images/noimage.png';
            }

            echo '<img width="125" style="border: 2px solid #d2d2d2;" src="' . $imgPath . '" />';
            ?>
        </div>

    </div>
    <br/>
    <br/>

    <?php
    
    
                                        if (!is_array($model->assigned_stations)) {
                                            $projects = explode(',', $model->assigned_stations);
                                        } else {
                                            $projects = $model->assigned_stations;
                                        }
                                                                                
            $agents = \common\models\LbStation::find()->where(['status' => 1])->all();
            if ($agents != NULL) {
                foreach ($agents as $agent) {
                    if (in_array($agent->id, $projects)) {                    
                        $age[$agent->id] = $agent->station_name; 
                        $sel[$agent->id] = array("selected"=>"selected");
                    }else{
                       $age[$agent->id] = $agent->station_name; 
                       $sel[$agent->id] = "";
                    }
                }
            } else {
                $age = [];
            }
            echo $form->field($model, 'assigned_stations')->dropDownList($age, ['multiple' => true, 'class' => 'form-control','options' => $sel]);
            ?>

    
    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
