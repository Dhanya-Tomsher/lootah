<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LbStockRequestManagement */

$this->title = 'Create Lb Stock Request Management';
$this->params['breadcrumbs'][] = ['label' => 'Lb Stock Request Managements', 'url' => ['index']];
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


                            <?= Html::a('Back to Lb Stock Request Management', ['index'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div
                    <div class="x_content">
                        <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                                    'id',
            'request_id',
            'supplier_id',
            'quantity_litre',
            'quantity_gallon',
            'date_entry',
            'supply_date',
            'supply_time',
            'assigned_by',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'created_by_type',
            'updated_by_type',
            'sort_order',
            'status',
                        ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



