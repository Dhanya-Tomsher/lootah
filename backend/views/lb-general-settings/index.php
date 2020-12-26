<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LbGeneralSettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lb General Settings';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?= Html::encode($this->title) ?> </h3>
            </div>

            <div class="title_right">

            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">

                        <?php if (Yii::$app->session->hasFlash("success")): ?>
                                <div class="alert alert-success alert-dismissable">
                                     <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                   
                                     <?= Yii::$app->session->getFlash("success") ?>
                                </div>
                            <?php endif; ?>

                            <?php if (Yii::$app->session->hasFlash("error")): ?>
                                <div class="alert alert-danger alert-dismissable">
                                     <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                     <?= Yii::$app->session->getFlash("error") ?>
                                </div>
                            <?php endif; ?>

                        <ul class="nav navbar-right panel_toolbox">
                                                                                            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                            
                            <?= Html::a('Create Lb General Settings', ['create'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                                                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                                        'id',
            'govt_price',
            'discount',
            'customer_price',
            [
                            'attribute' => 'month',
                            'filter' => ['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'],
                            'value' => function ($data) {
                            if ($data->month == 1) {
                                return "January";
                            } else if ($data->month == 2) {
                                return "February";
                            }else if ($data->month == 3) {
                                return "March";
                            }else if ($data->month == 4) {
                                return "April";
                            }else if ($data->month == 5) {
                                return "May";
                            }else if ($data->month == 6) {
                                return "June";
                            }else if ($data->month == 7) {
                                return "July";
                            }else if ($data->month == 8) {
                                return "August";
                            }else if ($data->month == 9) {
                                return "September";
                            }else if ($data->month == 10) {
                                return "October";
                            }else if ($data->month == 11) {
                                return "November";
                            }else if ($data->month == 12) {
                                return "December";
                            }else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
           // 'month',
            // 'year',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'created_by_type',
            // 'updated_by_type',
            // 'sort_order',
            // 'status',

                            ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Update',
                            'template' => '{update}'],
                            ['class' => 'yii\grid\ActionColumn',
                            'header' => 'View',
                            'template' => '{view}'],
                            ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Delete',
                            'template' => '{delete}'],
                            ],
                            ]); ?>
                                                                    </div>
                </div>
            </div>
        </div>
    </div>
</div>