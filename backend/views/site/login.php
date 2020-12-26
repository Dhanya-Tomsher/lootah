<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .error-summary p{
        display: none;
    }
    .error-summary {
        color: red;
    }
    .error-summary li {
        list-style: none;
    }
    p.help-block.help-block-error {
        display: none;
    }
</style>
<div id="login" class="animate form">
    <section class="login_content">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

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
        <h1>Login Form <?php //echo $get_type; ?></h1>
        <?= $form->errorSummary($model); ?>


        <div class="login-type">
            <label class="radio-inline"><input type="radio" value="1" name="type" <?php if ($get_type == 1) { ?>checked<?php } ?>>Admin</label>
            <!--<label class="radio-inline"><input type="radio" value="2" name="type" <?php //if ($get_type == 2) { ?>checked<?php //} ?>>Agent</label>-->
        </div>
        <div>
            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username/Email', 'class' => 'form-control'])->label(FALSE) ?>
        </div>
        <div>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control'])->label(FALSE) ?>
        </div>
        <div>
            <?= Html::submitButton('Login', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>


            <!--<a class="reset_pass" href="#">Lost your password?</a>-->
        </div>
        <div class="clearfix"></div>
        <div class="separator">
            <div class="clearfix"></div>
            <div>
                <h1><i class="fa fa-paw" style="font-size: 26px;"> </i>
                    <img src="<?= Yii::$app->request->baseUrl . '/images/logo.png' ?>" width = '70%' </h1>
                <p style="font-size: 12px">�<?php echo date("Y"); ?> All Rights Reserved. Lootah Biofuels!</p>
                <!--<p></p>-->
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <!-- form -->
    </section>
    <!-- content -->
</div>
