<?php

use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

?>
<?php
        if ($condition != '') {
            $url = "?" . $condition;
        } else {
            $url = "";
        }
        ?>
<div class = "right_col" role = "main" style = "min-height: 675px;">
<div class="box-gradient-home"></div>
<div class="page-content">
    <div class="page-content-inner">
        <h2 class="text-white"> Report</h2>
        <nav id="breadcrumbs" class="text-white">
            <ul>
                <li><a href="<?= Yii::$app->request->baseUrl; ?>/dashboard"> Dashboard </a></li>
                <li> Filter  Report</li>
            </ul>
        </nav>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="float-left"> Search Report</h4>
                        <?= Html::a('Export Data', ['exportclient' . $url], ['class' => 'btn btn-success float-right green']) ?>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <?php
                            $form = ActiveForm::begin(['method' => 'get', 'enableClientScript' => false, 'class' => 'uk-grid-small uk-grid', 'action' => 'client-report', 'options' => ['enctype' => 'multipart/form-data']]);
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
                                echo $form->field($model, 'station_id')->dropDownList(ArrayHelper::map(\common\models\LbStation::find()->all(), 'id', 'station_name'), ['prompt' => 'Choose a Station', 'class' => 'form-control']);
                                ?>
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                <?php
                                echo $form->field($model, 'client_id')->dropDownList(ArrayHelper::map(\common\models\LbClients::find()->where(['status' => 1])->all(), 'id', 'name'), ['prompt' => 'Choose Client', 'class' => 'form-control','id'=>'dept-list']);
                                ?>                                
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                <?php
                                echo $form->field($model, 'PlateNo')->dropDownList(ArrayHelper::map(\common\models\LbClientVehicles::find()->where(['status' => 1])->all(), 'vehicle_number', 'vehicle_number'), ['prompt' => 'Choose Vehicle', 'class' => 'form-control','id'=>'veh-list']);
                                ?>
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                <?= $form->field($model, 'date_from')->textInput(['maxlength' => 255, 'type' => 'datetime-local', 'class' => 'form-control your class']) ?>

                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                <?= $form->field($model, 'date_to')->textInput(['maxlength' => 255, 'type' => 'datetime-local', 'class' => 'form-control your class']) ?>
                            </div>

                            <div class="col-xl-2 col-md-2 col-sm-6 col-xs-12 mt-4 mb-2">
                                <div class="section-headline margin-top-25 margin-bottom-12">
                                    <h5></h5>
                                </div>
                                <button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Submit</button>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-xl-12 mb-3">
                <div class="card h-lg-100">
                    

                        <?php if (isset($_GET) && $_GET != NULL) { ?>
<div
                        class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                        <h4> Purchase Report</h4>
                    </div>
                    <div class="card-body pb-0">

                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'station_id',
                                        'header' => 'Station',
                                        'filter' => ArrayHelper::map(\common\models\LbStation::find()->all(), 'id', 'station_name'),
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Station", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'value' => function($data) {
                                            return $data->station->station_name;
                                        },
                                        'format' => 'html',
                                    ],
                                    'transaction_no',
                                    'PlateNo',
                                    'Volume',
                                    [
                                        'attribute' => 'EndTime',
                                        'header' => 'Time',
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Status", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'value' => function($data) {
                                            return date("Y-m-d H:i:s", strtotime($data->EndTime));
                                        },
                                        'format' => 'html',
                                    ],
                                ],
                            ]);
                            ?>
</div>
                        <?php } ?>
                    
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
        $('#dept-list').change(function(){
        var dep = $('#dept-list').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/site/get-veh",
                data: {dept_id: dep}
             }).done(function (data) {
                    $('#veh-list').html(data);
             });
  });
</script>
<style>
                .bgd{
                    background: #d7b668;
                    color: #000;
                    height: 36px;
                }
                </style>
