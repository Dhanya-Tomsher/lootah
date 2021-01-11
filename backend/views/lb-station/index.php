<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LbStationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lb Stations';
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

                            <?= Html::a('Create Lb Station', ['create'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'id',
                                'station_name',
                                'location',
                                //  'email:email',
                                //   'phone',
                                // 'address:ntext',
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
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Transaction',
                                    'template' => '{my_button_signature}',
                                    'buttons' => [
                                        'my_button_signature' => function ($url, $model, $key) {
                                            $class = 'done';

                                            return Html::a('<span class="' . $class . ' glyphicon glyphicon-plus"></span>', ['//transaction/index', 'station_id' => $model->id]);
                                            //return Html::a('<span class="' . $class . ' glyphicon glyphicon-plus"></span>', []);
                                        },
                                    ]
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>