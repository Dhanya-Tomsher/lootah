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
        <h2 class="text-white">Station Purchase Report</h2>
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
                        <?= Html::a('Export Data', ['exportpurchasedata' . $url], ['class' => 'btn btn-success float-right green']) ?>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <?php
                            $form = ActiveForm::begin(['method' => 'get', 'enableClientScript' => false, 'class' => 'uk-grid-small uk-grid', 'action' => 'station-purchase-report', 'options' => ['enctype' => 'multipart/form-data']]);
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
                                echo $form->field($model, 'station_id')->dropDownList(ArrayHelper::map(\common\models\LbStation::find()->where(['status' => 1])->all(), 'id', 'station_name'), ['prompt' => 'Choose Station', 'class' => 'form-control']);
                                ?>                                
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Select Month</h5>
                                    </div>
                                <select name="LbClientMonthlyPrice[month]" value="<?= $model->month;?>" class="form-control" id="lbclientmonthlyprice-month">
                                    <option value="">Select Month</option>
                                    <option value="1" <?php if($model->month == '1'){echo "Selected";} ?>>January</option>
                                    <option value="2" <?php if($model->month == '2'){echo "Selected";} ?>>February</option>
                                    <option value="3" <?php if($model->month == '3'){echo "Selected";} ?>>March</option>
                                    <option value="4" <?php if($model->month == '4'){echo "Selected";} ?>>April</option>
                                    <option value="5" <?php if($model->month == '5'){echo "Selected";} ?>>May</option>
                                    <option value="6" <?php if($model->month == '6'){echo "Selected";} ?>>June</option>
                                    <option value="7" <?php if($model->month == '7'){echo "Selected";} ?>>July</option>
                                    <option value="8" <?php if($model->month == '8'){echo "Selected";} ?>>August</option>
                                    <option value="9" <?php if($model->month == '9'){echo "Selected";} ?>>September</option>
                                    <option value="10" <?php if($model->month == '10'){echo "Selected";} ?>>October</option>
                                    <option value="11" <?php if($model->month == '11'){echo "Selected";} ?>>November</option>
                                    <option value="12" <?php if($model->month == '12'){echo "Selected";} ?>>December</option>
                                    </select>
                                </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Select Year</h5>
                                    </div>
                                <select name="LbClientMonthlyPrice[year]" class="form-control" id="lbclientmonthlyprice-year">
                                    <option value="">Select Year</option>
                                    <option value="2019" <?php if($model->year == '2019'){echo "Selected";} ?>>2019</option>
                                    <option value="2020" <?php if($model->year == '2020'){echo "Selected";} ?>>2020</option>
                                    <option value="2021" <?php if($model->year == '2021'){echo "Selected";} ?>>2021</option>
                                    </select>
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
                        <h4> Purchase List </h4>
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
                                        'header' => 'Station Name',
                                        'filter' => ArrayHelper::map(\common\models\LbStation::find()->all(), 'id', 'name'),
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Station", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'value' => function($data) {
                                            return $data->station->station_name;
                                        },
                                        'format' => 'html',
                                    ],
                                    //'customer_price',      
                                                'month',      
                                                'year',      
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
