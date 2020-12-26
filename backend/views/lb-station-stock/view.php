<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LbStationStock */

$this->title = 'Create Lb Station Stock';
$this->params['breadcrumbs'][] = ['label' => 'Lb Station Stocks', 'url' => ['index']];
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


                            <?= Html::a('Back to Lb Station Stock', ['index'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div
                    <div class="x_content">
                        <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                                    'id',
            'station_id',
            'opening_stock_litre',
            'opening_stock_gallon',
            'supplier_purchase_litre',
            'supplier_purchase_gallon',
            'tanker_load_litre',
            'tanker_load_gallon',
            'tanker_unload_litre',
            'tanker_unload_gallon',
            'station_sale_litre',
            'station_sale_gallon',
            'total_intake_litre',
            'total_intake_gallon',
            'total_out_litre',
            'total_out_gallon',
            'stock_in_dispenser_litre',
            'stock_in_dispenser_gallon',
            'date_entry',
            'day_entry',
            'month_entry',
            'year_entry',
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



