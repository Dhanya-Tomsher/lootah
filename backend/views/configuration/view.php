<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Configuration */

$this->title = 'Create Configuration';
$this->params['breadcrumbs'][] = ['label' => 'Configurations', 'url' => ['index']];
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


                            <?= Html::a('Back to Configuration', ['index'], ['class' => 'btn btn-success']) ?>


                        </ul>
                        <div class="clearfix"></div>
                    </div
                    <div class="x_content">
                        <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                                    'id',
            'name',
            'email:email',
            'additional_email:ntext',
            'phone',
            'office',
            'fax',
            'additional_phone:ntext',
            'latitude',
            'lonigtude',
            'logo',
            'fav',
            'facebook',
            'youtube',
            'instagram',
            'twitter',
            'platform',
            'status',
            'seo_title',
            'feild1',
            'feild2',
            'created_at',
            'updated_at',
            'seo_keyword:ntext',
            'seo_description:ntext',
                        ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



