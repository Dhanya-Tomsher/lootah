<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AbrajEventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Abraj Events';
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

                            <?= Html::a('Create Abraj Events', ['create'], ['class' => 'btn btn-success']) ?>


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
//                                        'id',
                                'title:ntext',
//            'title_ar:ntext',
//            'description:ntext',
//            'description_ar:ntext',
                                'date',
                                [
                                    'attribute' => 'status',
                                    'filter' => [0 => "Disable", 1 => 'Enable'],
                                    'value' => function($data) {
                                if ($data->status == 1) {
                                    return "Enable";
                                } else {
                                    return "Disable";
                                }
                            }
                                ],
                                // 'status',
                                // 'created_at',
                                // 'updated_at',
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