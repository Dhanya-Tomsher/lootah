<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */

$this->title = 'Create Transaction';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
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


                            <?= Html::a('Back to Transaction', ['index'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div
                    <div class="x_content">
                        <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                                    'UUID',
            'transaction_no',
            'ReferenceId',
            'SequenceId',
            'DeviceId',
            'Meter',
            'SecondaryTag',
            'Category',
            'Operator',
            'Asset',
            'AccumulatorType',
            'Sitecode',
            'Project',
            'PlateNo',
            'Master',
            'Accumulator',
            'Volume',
            'Allowance',
            'Type',
            'StartTime',
            'EndTime',
            'Status',
            'ServerTimestamp',
            'UpdateTimestamp',
                        ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



