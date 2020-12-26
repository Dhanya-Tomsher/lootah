<?php
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
?>
<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
<div class="box-gradient-home"></div>


<?php
$deps = \common\models\LbClients::find()->where(['id' => Yii::$app->session->get('armid')])->one();


?>
        <div class="page-content">
            <div class="page-content-inner">

                <h2 class="text-white"> Change Password</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"> Dashboard </a></li>
                        <li>  Change Password </li>
                    </ul>
                </nav>


               <div class="row">
                    <div class="col-lg-9">
                        <div class="card min-box">
                            <div class="card-header">
                                <h4> Change Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                         <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success alert-dismissable">
                            <?= Yii::$app->session->getFlash('pwssuccess') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger alert-dismissable">
                            <?= Yii::$app->session->getFlash('pwderror') ?>
                            </div>
                        <?php endif; ?>
                                        <form method="post" action="<?= Yii::$app->request->baseUrl; ?>/clients/changepwd" class="uk-child-width-1-2@s uk-grid-small p-4 uk-grid" uk-grid="">
                                            
                       
                        
                        <div class="uk-first-column">
                                    <h5 class="uk-text-bold mb-2"> Current Password </h5>
                                    <input class="uk-input" type="password" name="current" id="current"  placeholder="Current Password" required>
                                </div>
                                
                                <div class="uk-first-column">
                                    <h5 class="uk-text-bold mb-2"> New Password </h5>
                                    <input class="uk-input" type="password" name="password" id="password"  placeholder="New Password" required>
                                </div>
                                
                                <div class="uk-first-column">
                                    <h5 class="uk-text-bold mb-2">Confirm New Password </h5>
                                    <input class="uk-input" type="password" name="confirm" id="confirm"  placeholder="Re-enter New Password" required>
                                </div>
                                <div class="uk-width-auto@s">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                     </form>
                       <span id="error"></span>
                                    </div>

                               

                                  


                                </div>
                            </div>
                        </div>
                    </div>

                        
                    </div>
                </div>

           
            </div>
            
          <script src="<?= Yii::$app->request->baseUrl; ?>/js/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function () {
        $('#confirm').keyup(function () {
            Check(e = '');
        });
        $('#password').keyup(function () {
            Check(e = '');
        });
        $('#reset_form').submit(function (e) {
            Check(e);
        });
    });

    function Check(e) {
        var pass = $('#password').val();
        var confirm = $('#confirm').val();
        if (pass != '' && confirm != '') {

            if (pass != confirm) {
                $('#error').html(" Password doesn't match");
                if (e != '') {
                    e.preventDefault();
                }
            } else {
                $('#error').html("");
            }
        } else {
            $('#error').html("");
        }
    }
</script>
<style>
    #error{
        color:red;
    }
</style>
