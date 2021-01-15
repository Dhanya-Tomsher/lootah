<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
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

                            <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="search_data">

                            <?php echo $this->render('_search', array('model' => $searchModel)); ?>
                        </div>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                'UUID',
                                'transaction_no',
//                                'ReferenceId',
//                                'SequenceId',
                                [
                                    'attribute' => 'DeviceId',
                                    'header' => 'Device',
                                    'filter' => ArrayHelper::map(\common\models\Device::find()->all(), 'id', 'name'),
                                    //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                    'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Status", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                    'value' => function($data) {
                                        return $data->deviec->Name;
                                    },
                                    'format' => 'html',
                                ],
//                                'DeviceId',
//                                'Meter',
                                'SecondaryTag',
//                                'Category',
                                'Operator',
                                // 'Asset',
                                // 'AccumulatorType',
//                                 'Sitecode',
                                // 'Project',
                                'PlateNo',
                                'Master',
                                // 'Accumulator',
                                'Volume',
                                // 'Allowance',
                                // 'Type',
                                'StartTime',
                                'EndTime',
                                // 'Status',
                                'ServerTimestamp',
                                [
                                    'attribute' => 'station_id',
                                    'header' => 'Station',
                                    'filter' => ArrayHelper::map(\common\models\LbStation::find()->all(), 'id', 'station_name'),
                                    //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                    'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Status", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                    'value' => function($data) {
                                        return $data->station->station_name;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'dispenser_id',
                                    'header' => 'Dispenser',
                                    'filter' => ArrayHelper::map(\common\models\Dispenser::find()->all(), 'id', 'label'),
                                    //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                    'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Status", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                    'value' => function($data) {
                                        return $data->dispenser->label;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'nozle_id',
                                    'header' => 'Nozzle',
                                    'filter' => ArrayHelper::map(\common\models\Nozzle::find()->all(), 'id', 'label'),
                                    //'filter' => ['1' => 'Request Pending', '2' => 'Request Accepted', '3' => 'Unit Visit Done ', '4' => 'Reserved', '5' => 'Booked', '6' => 'Not Interested'],
                                    'filterInputOptions' => ['class' => 'form-control selectpicker', 'id' => null, 'prompt' => 'All', 'data-live-search' => "true", 'title' => "Select a Status", 'data-hide-disabled' => "true"], // to change 'Todos' instead of the blank option
                                    'value' => function($data) {
                                        return $data->nozzle->label;
                                    },
                                    'format' => 'html',
                                ],
                                // 'UpdateTimestamp',
//                            ['class' => 'yii\grid\ActionColumn',
//                            'header' => 'Update',
//                            'template' => '{update}'],
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'View',
                                    'template' => '{view}'],
//                            ['class' => 'yii\grid\ActionColumn',
//                            'header' => 'Delete',
//                            'template' => '{delete}'],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>