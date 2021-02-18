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
//var_dump($condition);exit;
        if ($condition != '') {
            $url = "?" . $condition;
        } else {
            $url = "";
        }
        ?>
<div class = "right_col" role = "main" style = "min-height: 675px;">
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
        
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="float-left">  Sales  Report</h4>
                        <?= Html::a('Export Data', ['exportsupplierbooking' . $url], ['class' => 'btn btn-success float-right green']) ?>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <?php
                            $form = ActiveForm::begin(['method' => 'get', 'enableClientScript' => false, 'class' => 'uk-grid-small uk-grid', 'action' => 'bookedqtyreport', 'options' => ['enctype' => 'multipart/form-data']]);
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
                                echo $form->field($model, 'supplier_id')->dropDownList(ArrayHelper::map(\common\models\LbSupplier::find()->all(), 'id', 'name'), ['prompt' => 'Choose Supplier', 'class' => 'form-control']);
                                ?>
                            </div>
                            <div class="col-xl-4 col-md-4 mb-2">
                                <?= $form->field($model, 'booking_date')->textInput(['maxlength' => 255, 'type' => 'datetime-local', 'class' => 'form-control your class'])->label('Booking From'); ?>
                            </div>
                           <div class="col-xl-4 col-md-4 mb-2">
                                <?= $form->field($model, 'created_at')->textInput(['maxlength' => 255, 'type' => 'datetime-local', 'class' => 'form-control your class'])->label('Booking To'); ?>
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
                        <h4>Supplier Booking Report</h4>
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
                                        'attribute' => 'supplier_id',
                                        'header' => 'Supplier',
                                        'filter' => ArrayHelper::map(\common\models\LbSupplier::find()->all(), 'id', 'name'),
                                        //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select Supplier", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'filter' => false,
                                        'value' => function($data) {
                                            return $data->supplier->name;
                                        },
                                        'format' => 'html',
                                    ],
                                    'booking_date',
                                    'booked_quantity_gallon',
                                    'booked_quantity_litre',                                   
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