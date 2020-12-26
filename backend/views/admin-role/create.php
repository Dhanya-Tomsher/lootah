<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdminRole */

$this->title = 'Create Admin Role';
$this->params['breadcrumbs'][] = ['label' => 'Admin Roles', 'url' => ['index']];
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



                            <?= Html::a('Back to Admin Role', ['index'], ['class' => 'btn btn-success']) ?>



                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?=
                        $this->render('_form', [
                            'model' => $model,
                            'role' => $role,
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



