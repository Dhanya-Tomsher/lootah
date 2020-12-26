<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\LbDailyTankerCollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lb Daily Tanker Collections';
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
                            
                            <?= Html::a('Create Lb Daily Tanker Collection', ['create'], ['class' => 'btn btn-success']) ?>


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
            [
                            'attribute' => 'tanker_id',
                            'filter' => ArrayHelper::map(\common\models\LbTanker::find()->where(['status' => 1])->all(), 'id', 'tanker_number'),
                            'value' => function ($data) {
                            if ($data->tanker_id != NULL) {
                                return $data->tanker->tanker_number;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
           // 'tanker_id',
             [
                            'attribute' => 'operator_id',
                            'filter' => ArrayHelper::map(\common\models\LbTankerOperator::find()->where(['status' => 1])->all(), 'id', 'name'),
                            'value' => function ($data) {
                            if ($data->operator_id != NULL) {
                                return $data->operator->name;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
          //  'operator_id',
          //  'client_type',
          //  'vehicle_id',
            // 'collection_type',
            // 'quantity_gallon',
            // 'quantity_litre',
            // 'amount_litre',
            // 'amount_gallon',
            // 'supervisor_approval_status',
            // 'supervisor_approved_by',
            // 'area_manager_approval_status',
            // 'area_manager_approved_by',
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