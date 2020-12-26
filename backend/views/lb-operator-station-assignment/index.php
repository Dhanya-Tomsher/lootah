<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LbOperatorStationAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lb Operator Station Assignments';
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
                            
                            <?= Html::a('Create Lb Operator Station Assignment', ['create'], ['class' => 'btn btn-success']) ?>


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
           // 'operator_id',
            [
                            'attribute' => 'operator_id',
                            'filter' => ArrayHelper::map(\common\models\LbStationOperator::find()->where(['status' => 1])->all(), 'id', 'name'),
                            'value' => function ($data) {
                            if ($data->operator_id != NULL) {
                                return $data->operator->name;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
                                    
                                    [
                            'attribute' => 'station_id',
                            'filter' => ArrayHelper::map(\common\models\LbStation::find()->where(['status' => 1])->all(), 'id', 'station_name'),
                            'value' => function ($data) {
                            if ($data->station_id != NULL) {
                                return $data->station->station_name;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
          //  'station_id',
                                    
                         /*                   [
                            'attribute' => 'assigned_by',
                            'filter' => ArrayHelper::map(\common\models\LbSupervisor::find()->where(['status' => 1])->all(), 'id', 'name'),
                            'value' => function ($data) {
                            if ($data->assigned_by != NULL) {
                                return $data->supervisor->name;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],*/
           // 'assigned_by',
           // 'date_assignment',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'created_by_type',
            // 'updated_by_type',
            // 'sort_order',
            // 'status',

                           /* ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Update',
                            'template' => '{update}'],*/
                            ['class' => 'yii\grid\ActionColumn',
                            'header' => 'View',
                            'template' => '{view}'],
                           /* ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Delete',
                            'template' => '{delete}'],*/
                            ],
                            ]); ?>
                                                                    </div>
                </div>
            </div>
        </div>
    </div>
</div>