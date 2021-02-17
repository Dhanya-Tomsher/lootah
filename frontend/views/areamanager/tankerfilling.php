<?php

use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
?>
<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
<div class="box-gradient-home"></div>
<div class="page-content">
    <div class="page-content-inner">
        <h2 class="text-white"> Add Tanker Filling</h2>
        <nav id="breadcrumbs" class="text-white">
            <ul>
                <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/dashboard"> Dashboard </a></li>
                <li> Add Tanker Filling</li>
            </ul>
        </nav>
         <?php
        $station_list = [];
        $get_stations = common\models\LbAreaManager::find()->where(['id' => Yii::$app->session->get('armid')])->one();
        if ($get_stations != NULL) {
            if ($get_stations->assigned_stations != "") {
                $station_list = explode(',', $get_stations->assigned_stations);
            }
        }
//        assigned_stations
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Add Tanker Filling Details </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">                                
                            <?php
                            $form = ActiveForm::begin(['enableClientScript' => false, 'class' => 'uk-grid-small uk-grid', 'action' => 'tankerfilling', 'options' => ['enctype' => 'multipart/form-data']]);
                            $model = new \common\models\LbTankerFilling();
                            ?>
                            <div class="col-xl-12 col-md-12">
                                <?php if (Yii::$app->session->hasFlash('success')): ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <?= Yii::$app->session->getFlash('success') ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (Yii::$app->session->hasFlash('error')): ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <?= Yii::$app->session->getFlash('error') ?>
                                    </div>
                                <?php endif; ?>
                            </div>                                
                            <div class="col-xl-4 col-md-4 mb-2">
                                <?php
                                echo $form->field($model, 'station_id')->dropDownList(ArrayHelper::map(\common\models\LbStation::find()->where(['in', 'id', $station_list])->all(), 'id', 'station_name'), ['prompt' => 'Choose Station', 'class' => 'form-control']);
                                 ?>
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                <?php
                                echo $form->field($model, 'tanker_id')->dropDownList(ArrayHelper::map(\common\models\LbTanker::find()->all(), 'id', 'tanker_number'), ['prompt' => 'Choose Tanker', 'class' => 'form-control','id'=>'lbtankerfilling-tanker_id']);
                                 ?> 
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                    <?= $form->field($model, 'quantity_gallon')->textInput(['maxlength' => true, 'class' => 'form-control', 'required' => 'required']) ?>                    
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                    <?= $form->field($model, 'date_entry')->textInput(['maxlength' => true, 'class' => 'form-control', 'required' => 'required']) ?>                    
                            </div>      
                            <div class="col-xl-2 col-md-2 col-sm-6 col-xs-12 mt-4 mb-2">
                                <div class="section-headline margin-top-25 margin-bottom-12">
                                    <h5></h5>
                                </div>																
                                <button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Submit</button></div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


<style>
    .bgd{
        background: #d7b668;
        color: #000;
        height: 36px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>            
<script>
        $('#lbtankerfilling-station_id').change(function(){
        var dep = $('#lbtankerfilling-station_id').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/supervisor/get-tanker",
                data: {dept_id: dep}
             }).done(function (data) {
                    $('#lbtankerfilling-tanker_id').html(data);
             });
  });
</script>