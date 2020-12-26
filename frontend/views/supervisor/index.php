<?php
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div uk-height-viewport class="uk-flex uk-flex-middle bg-gradient-primary log-wrap">
        <div class="uk-width-1-3@m uk-width-1-3@s m-auto rounded">
            <div class="uk-child-width-1-1@m uk-grid-collapse " uk-grid>
                <!-- column one -->
                <div class="uk-margin-auto-vertical uk-text-center uk-animation-scale-up uk-light">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/lootah.png" />                   
                </div>
                <!-- column two -->
                <div class="uk-card-default py-4 px-5">
                    <div class="mt-4 mb-2 uk-text-center">
                        <h3 class="mb-0"> Supervisor Login</h3>
                        <p class="my-2">Login to manage your account.</p>
                    </div>
                    <?php $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'login']); 
                    $userr = new \common\models\LbSupervisor();
                    ?>
                    <?php if (Yii::$app->session->hasFlash('successlog')): ?>
                            <div class="alert alert-success alert-dismissable">
                            <?= Yii::$app->session->getFlash('successlog') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->session->hasFlash('errorlog')): ?>
                            <div class="alert alert-danger alert-dismissable">
                            <?= Yii::$app->session->getFlash('errorlog') ?>
                            </div>
                        <?php endif; ?>
                        <div class="uk-form-group">
                            <label class="uk-form-label"> Email</label>

                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="icon-feather-mail"></i>
                                </span>
                                <?= $form->field($userr, 'email')->textInput(['class'=>'uk-input','maxlength' => true, 'id' => 'email', 'placeholder' => 'Email'])->label(FALSE);
                                ?>
                            </div>
                        </div>
                        <div class="uk-form-group">
                            <label class="uk-form-label"> Password</label>

                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="icon-feather-lock"></i>
                                </span>
                                <?= $form->field($userr, 'password')->passwordInput(['class'=>'uk-input','maxlength' => true, 'id' => 'password', 'placeholder' => 'Password'])->label(FALSE);
                                ?>
                            </div>
                        </div>
                        <span class="uk-text-info forg"><a href="forgot">Forgot Password</a></span>                        
                        <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                            <div class="uk-width-expand@s">
                            </div>
                            <div class="uk-width-auto@s">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>				
                            <p class="form-messege mb-0"></p>

                            <?php ActiveForm::end(); ?>
                </div><!--  End column two -->
            </div>
        </div>
    </div>
<style>
    input, input[type="text"]{
    padding: 0 36px;
    }
    input, input[type="password"]{
    padding: 0 36px;
    }
</style>
