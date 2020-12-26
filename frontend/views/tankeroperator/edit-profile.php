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
$deps = \common\models\LbTankerOperator::find()->where(['id' => Yii::$app->session->get('tanopid')])->one();
?>
        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">

                <h2 class="text-white">Edit Profile</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/tankeroperator/dashboard"> Dashboard </a></li>
                        <li>Edit Profile </li>
                    </ul>
                </nav>


               <div class="row">
                    <div class="col-12">
                        <div class="card min-box">
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">                                  

                    <div class="col-lg-12 col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h4> Contact info </h4>
                            </div>
                            <?php 
                            $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'edprofile','options' => ['enctype' => 'multipart/form-data']]); 
                            $model= \common\models\LbTankerOperator::find()->where(['id' => Yii::$app->session->get('tanopid')])->one();
                            ?>
                            <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <?php
                                        if($deps->image){
                                        ?>
                                        <img src="<?= Yii::$app->request->baseUrl . '/uploads/tankeroperator/' . $model->id . '/' . $model->image; ?>"
                                        class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                    
                                    <?php
                                        }else{
                                        ?>
                                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/team/team-1.jpg"
                                        class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                    <?php
                                        }
                                        ?>
                                    </div>
                             <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                                    <?= $form->field($model, 'image')->fileInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                                    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>
                            <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>
                            
                            <hr class="mb-0">
                            <div class="uk-flex uk-flex-right p-3">
                                <a href="#" class="btn btn-soft-primary btn-sm mr-2">Cancel</a>
                            <button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Update</button></div>
                                        <?php ActiveForm::end(); ?>
                        </div>
                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    

                      

                </div>

           
            </div>
            
            <script src="/biofuels/admin/assets/9f965b76/js/fileinput.js"></script>