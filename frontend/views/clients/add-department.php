<?php
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
<div class="box-gradient-home"></div>

        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">

                <h2 class="text-white"> Add Department </h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"> Dashboard </a></li>
                        <li> Add Department </li>
                    </ul>
                </nav>


               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Add Department Details</h4>
                            </div>
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
                            <div class="card-body">
                                <div class="row">
                                
                                <?php 
                                    $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'adddepartment']); 
                                    $model=new \common\models\LbClientDepartments();
                                    ?>
                                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                            <?= $form->field($model, 'department')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                        </div>
                                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mt-4 mb-4">
                                            <div class="section-headline margin-top-25 margin-bottom-12">
                                            <h5></h5>
                                            </div>									
					<button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Add</button>
                 
					</div>

                                    <?php ActiveForm::end(); ?>
                                   

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12 col-xl-12 mb-3">
                        <div class="card h-lg-100">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4> Departments</h4>                                
                            </div>
                            <div class="card-body pb-0">
                                <div class="media align-items-center position-relative bgd">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Department</p>
                                    </div>                                     
                                    <div class="uk-position-top-right uk-margin-medium-right p-3" style="top: -9px!important;">
                                        <p class="font-weight-semi-bold mb-0 text-500">Edit</p>
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                $deps = \common\models\LbClientDepartments::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                                foreach($deps as $depts){
                                ?>
                                <div class="media align-items-center position-relative">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->department; ?></p>
                                    </div>                                    
                                    <div class="uk-position-top-right uk-margin-medium-right p-3">
                                        <a href="#modal-group-<?= $depts->id; ?>" uk-toggle  class="btn btn-icon btn-light btn-sm" uk-tooltip="Edit">
                                        <span class="uil-edit"></span> </a>
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
                        <?php
                            $deps = \common\models\LbClientDepartments::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                            foreach($deps as $depts){
                        ?>
			<div id="modal-group-<?= $depts->id; ?>" uk-modal> <div class="uk-modal-dialog"> <button class="uk-modal-close-default" type="button" uk-close></button> 				
			<div class="uk-modal-header"> <h2 class="uk-modal-title">Edit Department</h2> </div> 
				<div class="uk-modal-body"> <div class="row"> 
                        <?php
                        $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'upddepartment']); 
                        ?>
                            <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                             <?= $form->field($model, 'department')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$depts->department]) ?>
                                <input type="hidden" name="LbClientDepartments[id]" id="lbclientdepartments-id" value="<?= $depts->id; ?>">           
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?php 
                            $age[1] = "Enable";    
                            $age[0] ="Disable";                            
                            if($depts->status == 1){
                            $sel[1] = array("selected"=>"selected");
                            $sel[0] ="";
                            }else if($depts->status == 0){
                            $sel[0] = array("selected"=>"selected");
                            $sel[1] ="";
                            }
                            //$form->field($model, 'status')->dropDownList($age,['class' => 'form-control','options'=>$sel]);
                            ?>
				<?= $form->field($model, 'status')->dropDownList($age,['class' => 'form-control']); ?>                
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