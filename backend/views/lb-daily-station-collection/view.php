<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LbDailyStationCollection */

$this->title = 'Create Lb Daily Station Collection';
$this->params['breadcrumbs'][] = ['label' => 'Lb Daily Station Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <ul class="nav navbar-right panel_toolbox">
                        <!--<li>---</li>-->
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">


                            <?= Html::a('Back to Lb Daily Station Collection', ['index'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div
                    <div class="x_content">
                        <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                                    'id',
            'station_id',
            'operator_id',
            'nozzle',
            'client_type',
            'client_id',
            'vehicle_id',
            'vehicle_number',
            'odometer_reading',
            'collection_type',
            'quantity_gallon',
            'quantity_litre',
            'amount',
            'opening_stock',
            'closing_stock',
            'edited_by',
            'description_for_edit:ntext',
            'edit_approval_status',
            'edit_approved_by',
            'edit_approval_comments:ntext',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'created_by_type',
            'updated_by_type',
            'sort_order',
            'status',
            'supervisor_verification_status',
            'supervisor_verified_by',
            'area_manager_verification_status',
            'area_manager_verified_by',
                        ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



