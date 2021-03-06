<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LbTankerDailyDataForVerification */

$this->title = 'Create Lb Tanker Daily Data For Verification';
$this->params['breadcrumbs'][] = ['label' => 'Lb Tanker Daily Data For Verifications', 'url' => ['index']];
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


                            <?= Html::a('Back to Lb Tanker Daily Data For Verification', ['index'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div
                    <div class="x_content">
                        <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                                    'id',
            'tanker_id',
            'date_entry',
            'unit',
            'physical_stock_gallon',
            'stock_by_calculation_gallon',
            'physical_stock',
            'stock_by_calculation',
            'stock_difference',
            'closing_stock',
            'physical_stock_litre',
            'stock_by_calculation_litre',
            'stock_difference_gallon',
            'stock_difference_litre',
            'physica_data_entered_by',
            'closing_stock_gallon',
            'closing_stock_litre',
            'sold_qty',
            'cash_sales',
            'card_sales',
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



