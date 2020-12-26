<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AbrajEvents */

$this->title = 'Create Abraj Events';
$this->params['breadcrumbs'][] = ['label' => 'Abraj Events', 'url' => ['index']];
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



                            <?= Html::a('Back to Abraj Events', ['index'], ['class' => 'btn btn-success']) ?>



                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?= $this->render('_form', [
                        'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



