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
        <div class="page-content">
            <div class="page-content-inner">
                <h2 class="text-white"> Add Tanker Operator</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> Dashboard </a></li>
			<li> Add Tanker Operator</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Add Tanker Operator Details </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">                                
                            <?php 
                            $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'addtnoperator','options' => ['enctype' => 'multipart/form-data']]); 
                            $model= new \common\models\LbTankerOperator;
                            ?>
                                    <div class="col-xl-12 col-md-12">
                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success alert-dismissable">
                            <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger alert-dismissable">
                            <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php endif; ?>
                                        </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control','required'=>'required']) ?>
                                </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class'=>'form-control','required'=>'required']) ?>
                                </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'password')->textInput(['maxlength' => true,'class'=>'form-control','required'=>'required']) ?>
                                </div>
                                    <div class="col-xl-4 col-md-4 mb-2">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Tanker</h5>
                            </div>
                
                            <select id="lboperatorstationassignment-station_id" class="selectpicker" name="LbTankerOperator[tanker]">
                                        <option value="">Select Tanker</option>
                                        <?php
                                        $stnz= \common\models\LbTanker::find()->where(['status'=>1])->all();
                                        foreach($stnz as $stnzs){
                                        ?>
                                        <option value="<?= $stnzs->id; ?>"><?= $stnzs->tanker_number; ?></option>
                                        <?php
                                        }
                                        ?>
                            </select> 
                        </div>
                                <div class="col-xl-4 col-md-4 mb-2">    
                                        <?= $form->field($model, 'image')->fileInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-6 col-xs-12 mt-4 mb-2">
				<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5></h5>
                                </div>																
                                    <button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Submit</button></div>
				</div>

                                 <?php ActiveForm::end(); ?>
                                
                                </div>
                            </div>
                        </div>
                   
                   <div class="col-lg-12 col-xl-12 mb-3">
                        <div class="card h-lg-100">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4> Tanker Operator List</h4>                                
                            </div>
                            <div class="card-body pb-0">
                                <div class="media align-items-center position-relative bgd">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Sl.No</p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Name</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Username</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Password</p>
                                    </div>
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Tanker</p>
                                    </div>
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Status</p>
                                    </div> 
                                     <div class="uk-position-top-right uk-margin-medium-right p-3" style="top: -9px!important;">
                                        <p class="font-weight-semi-bold mb-0 text-500">Edit</p>
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                $i=1;
                                $deps = \common\models\LbTankerOperator::find()->all();
                                foreach($deps as $depts){
                                ?>
                                <div class="media align-items-center position-relative">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">
                                           <?= $i; ?>
                                        </p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">
                                            <?php
                                        if($depts->image){
                                        ?>
                                        <img src="<?= Yii::$app->request->baseUrl . '/uploads/tankeroperator/' . $depts->id . '/' . $depts->image; ?>"
                                              alt="avatar" width="100" height="100">
                                    
                                    <?php
                                        }
                                        ?><br/>
                                           <?= $depts->name; ?>
                                        </p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->username; ?></p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->password; ?></p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= \common\models\LbTanker::find()->where(['id'=>$depts->tanker])->one()->tanker_number; ?></p>
                                    </div>
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?php if($depts->status == 1){echo "Active";}else{echo "Deactive";}; ?></p>
                                    </div> 
                                    <div class="uk-position-top-right uk-margin-medium-right p-3">
                                        <a href="#modal-group-<?= $depts->id; ?>" uk-toggle  class="btn btn-icon btn-light btn-sm" uk-tooltip="Edit">
                                        <span class="uil-edit"></span> </a>
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                $i=$i+1;
                                }
                                ?>
                            </div>
                        </div>
                    </div> 
                   
                    </div>
                </div>
				           
            </div>


                        <?php
                            $deps = \common\models\LbTankerOperator::find()->where(['status' => 1])->all();
                            foreach($deps as $depts){
                        ?>
			<div id="modal-group-<?= $depts->id; ?>" uk-modal> <div class="uk-modal-dialog"> <button class="uk-modal-close-default" type="button" uk-close></button> 				
			<div class="uk-modal-header"> <h2 class="uk-modal-title">Edit Tanker Operator</h2> </div> 
				<div class="uk-modal-body"> <div class="row"> 
                        <?php
                        $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'edittnoperator','options' => ['enctype' => 'multipart/form-data']]); 
                        ?>
                        <input type="hidden" name="LbTankerOperator[id]" id="lbtankeroperator-id" value="<?= $depts->id; ?>">    
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$depts->name,'required'=>'required']) ?>
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$depts->username,'required'=>'required']) ?>
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'password')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$depts->password,'required'=>'required']) ?>                                              
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                        <select id="lbtankeroperator-tanker" class="selectpicker" name="LbTankerOperator[tanker]">
                                        <option value="">Select Tanker</option>
                                        <?php
                                        $stnz= \common\models\LbTanker::find()->where(['status'=>1])->all();
                                        foreach($stnz as $stnzs){
                                        ?>
                                        <option value="<?= $stnzs->id; ?>" <?php if($depts->tanker == $stnzs->id){echo "selected";}else{} ?>><?= $stnzs->tanker_number; ?></option>
                                        <?php
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?php
                                        if($depts->image){
                                        ?>
                                        <img src="<?= Yii::$app->request->baseUrl . '/uploads/tankeroperator/' . $depts->id . '/' . $depts->image; ?>"
                                        class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                    
                                    <?php
                                        }
                                        ?>
                            <?= $form->field($model, 'image')->fileInput(['maxlength' => true,'class'=>'form-control']) ?>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mt-4 mb-4">
				<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5></h5>
                                </div>									
				<button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Update</button>                 
			</div>
                        <?php ActiveForm::end(); ?>
                                </div></div> 
				</div> </div> 
                        <?php
                            }
                        ?>


 <style>
                .bgd{
                    background: #d7b668;
                    color: #000;
                    height: 36px;
                }
                </style>