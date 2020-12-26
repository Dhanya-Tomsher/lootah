<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LbClientVehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lb Client Vehicles';
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
                            
                            <?= Html::a('Create Lb Client Vehicles', ['create'], ['class' => 'btn btn-success']) ?>


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
            //'client_id',
            [
                            'attribute' => 'client_id',
                            'filter' => ArrayHelper::map(\common\models\LbClients::find()->where(['status' => 1])->all(), 'id', 'name'),
                            'value' => function ($data) {
                            if ($data->client_id != NULL) {
                                return $data->client->name;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
            //'department_id',
                                    [
                            'attribute' => 'department_id',
                            'filter' => ArrayHelper::map(\common\models\LbClientDepartments::find()->where(['status' => 1])->all(), 'id', 'department'),
                            'value' => function ($data) {
                            if ($data->department_id != NULL) {
                                return $data->department->department;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
           // 'vehicle_type',
                                            [
                            'attribute' => 'vehicle_type',
                            'filter' => ArrayHelper::map(\common\models\LbVehicleType::find()->where(['status' => 1])->all(), 'id', 'vehicle_type'),
                            'value' => function ($data) {
                            if ($data->vehicle_type != NULL) {
                                return $data->vehicletype->vehicle_type;
                            } else {
                                return 'Not set';
                            }
                            },
                                'format' => 'html',
                            ],
            'vehicle_number',
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
                            ]); 
                            ?>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>