<?php

use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use yii\grid\GridView;
?>
<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
<div class="box-gradient-home"></div>
<div class="page-content">
    <div class="page-content-inner">
        <h2 class="text-white"> Sales Report</h2>
        <nav id="breadcrumbs" class="text-white">
            <ul>
                <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> Dashboard </a></li>
                <li> Sales Report</li>
            </ul>
        </nav>
<?php
        if ($condition != '') {
            $url = "?" . $condition;
        } else {
            $url = "";
        }
        ?>
        <?php
        $station_list = [];
        $get_stations = common\models\LbSupervisor::find()->where(['id' => Yii::$app->session->get('supid')])->one();
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
                        <h4 class="float-left">  Sales  Report</h4>
                        <?= Html::a('Export Data', ['exportsales' . $url], ['class' => 'btn btn-success float-right green']) ?>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <?php
                            $form = ActiveForm::begin(['method' => 'get', 'enableClientScript' => false, 'class' => 'uk-grid-small uk-grid', 'action' => 'salesreport', 'options' => ['enctype' => 'multipart/form-data']]);
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
                        <h4> Transaction Report</h4>
                    </div>
                    <div class="card-body pb-0">
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
//                                'UUID',
                                    [
                                        'attribute' => 'station_id',
                                        'header' => 'Station',
                                        'filter' => ArrayHelper::map(\common\models\LbStation::find()->all(), 'id', 'station_name'),
                                        //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Station", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'filter' => false,
                                        'value' => function($data) {
                                            return $data->station->station_name;
                                        },
                                        'format' => 'html',
                                    ],
                                    'transaction_no',
//                                'ReferenceId',
//                                'SequenceId',
                                    [
                                        'attribute' => 'dispenser_id',
                                        'header' => 'Dispenser',
//                                        'filter' => ArrayHelper::map(\common\models\Dispenser::find()->all(), 'id', 'label'),
                                        //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Dispenser", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'filter' => false,
                                        'value' => function($data) {
                                            return $data->dispenser->label;
                                        },
                                        'format' => 'html',
                                    ],
                                    [
                                        'attribute' => 'nozle_id',
                                        'header' => 'Nozzle',
//                                        'filter' => ArrayHelper::map(\common\models\Nozzle::find()->all(), 'id', 'label'),
                                        //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Nozzle", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'filter' => false,
                                        'value' => function($data) {
                                            return $data->nozzle->label;
                                        },
                                        'format' => 'html',
                                    ],
//                                'DeviceId',
//                                'Meter',
//                                'SecondaryTag',
//                                'Category',
                                    'Operator',
                                    // 'Asset',
                                    // 'AccumulatorType',
//                                 'Sitecode',
                                    // 'Project',
                                    'PlateNo',
//                                'Master',
                                    // 'Accumulator',
                                    'Volume',
                                    // 'Allowance',
                                    // 'Type',
//                                'StartTime',
//                                'EndTime',
                                    [
                                        'attribute' => 'EndTime',
                                        'header' => 'Time',
//                                    'filter' => ArrayHelper::map(\common\models\Device::find()->all(), 'device_id', 'name'),
                                        //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Status", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'value' => function($data) {
                                            return date("Y-m-d H:i:s", strtotime($data->EndTime));
                                        },
                                        'filter' => false,
                                        'format' => 'html',
                                    ],
                                // 'Status',
//                                'ServerTimestamp',
                                // 'UpdateTimestamp',
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

<style>
    .bgd{
        background: #d7b668;
        color: #000;
        height: 36px;
    }
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script>
    function getval(val) {
        $.ajax({
            type: "POST",
            url: "<?= Yii::$app->request->baseUrl; ?>/supervisor/calibdet",
            data: 'station_id=' + val,
            success: function (data) {
                $("#physical_quantity_gallon").html(data);
            }
        });
    }
    function getval1(val) {
        $.ajax({
            type: "POST",
            url: "<?= Yii::$app->request->baseUrl; ?>/supervisor/calibdetcal",
            data: 'station_id=' + val,
            success: function (data) {
                $("#quantity_calculation_gallon").html(data);
            }
        });
    }

</script>