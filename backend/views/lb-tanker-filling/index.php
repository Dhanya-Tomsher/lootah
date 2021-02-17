<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LbTankerFillingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lb Tanker Fillings';
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
                            
                            <?= Html::a('Create Lb Tanker Filling', ['create'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                                                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                                    //    'id',
            //'tanker_id',
             [
                                        'attribute' => 'station_id',
                                        'header' => 'Station',
                                        'filter' => ArrayHelper::map(\common\models\LbStation::find()->all(), 'id', 'station_name'),
                                        //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select Station", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'filter' => false,
                                        'value' => function($data) {
                                            return $data->station->station_name;
                                        },
                                        'format' => 'html',
                                    ],
                                                [
                                        'attribute' => 'tanker_id',
                                        'header' => 'Tanker',
                                        'filter' => ArrayHelper::map(\common\models\LbTanker::find()->all(), 'id', 'tanker_number'),
                                        'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select Tanker", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                        'filter' => false,
                                        'value' => function($data) {
                                            return $data->tanker->tanker_number;
                                        },
                                        'format' => 'html',
                                    ],
           // 'tanker_operator',
            //'station_operator',
            // 'quantity_litre',
             'quantity_gallon',
             'date_entry',
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