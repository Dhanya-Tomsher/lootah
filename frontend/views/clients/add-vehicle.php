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
                <h2 class="text-white"> Add Vehicle </h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"> Dashboard </a></li>
                        <li> Add Vehicle </li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Vehicle Details</h4>
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
                                    $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'addvehicle']); 
                                    $model=new \common\models\LbClientVehicles();
                                    ?>                        
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <?php
                                $de_types = \common\models\LbClientDepartments::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
                                if ($de_types != NULL) {
                                foreach ($de_types as $de_type) {
                                    $prode[$de_type->id] = $de_type->department;
                                }
                                } else {
                                    $prode = [];
                                }
                                    echo $form->field($model, 'department_id')->dropDownList($prode, ['prompt' => 'Choose Department', 'class' => 'selectpicker','id'=>'dept-list']);
                            ?>                           
                        </div>                
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">
                            <?php
                                $ve_types = \common\models\LbVehicleType::find()->where(['status' => 1])->all();
                                if ($ve_types != NULL) {
                                foreach ($ve_types as $ve_type) {
                                    $prove[$ve_type->id] = $ve_type->vehicle_type;
                                }
                                } else {
                                    $prove = [];
                                }
                                    echo $form->field($model, 'vehicle_type')->dropDownList($prove, ['prompt' => 'Choose Vehicle Type', 'class' => 'form-control']);
                            ?>
                        </div>									
			<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">				
                            <?= $form->field($model, 'vehicle_number')->textInput(['maxlength' => true,'class'=>'form-control']) ?>                          
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
                                <h4> Vehicles</h4>                                
                            </div>
                            <div class="card-body pb-0">
                                <div class="media align-items-center position-relative bgd">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Department</p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Vehicle Type</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Vehicle Number</p>
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
                                $deps = \common\models\LbClientVehicles::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                                foreach($deps as $depts){
                                ?>
                                <div class="media align-items-center position-relative">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">
                                            <?php 
                                            if($depts->department_id){
                                            echo $client_odps = \common\models\LbClientDepartments::find()->where(['id' => $depts->department_id])->one()->department; 
                                            }
                                            ?>
                                        </p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">
                                        <?php 
                                        if($depts->vehicle_type){
                                        echo $client_odps = \common\models\LbVehicleType::find()->where(['id' => $depts->vehicle_type])->one()->vehicle_type;
                                        }
                                        ?></p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->vehicle_number; ?></p>
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
                                }
                                ?>
                            </div>
                        </div>
                    </div> 
                   
                </div>
            </div>
            
                        <?php
                            $deps = \common\models\LbClientVehicles::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                            foreach($deps as $depts){
                        ?>
			<div id="modal-group-<?= $depts->id; ?>" uk-modal> <div class="uk-modal-dialog"> <button class="uk-modal-close-default" type="button" uk-close></button> 				
			<div class="uk-modal-header"> <h2 class="uk-modal-title">Edit Vehicle</h2> </div> 
				<div class="uk-modal-body"> <div class="row"> 
                        <?php
                        $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'updvehicle']); 
                        ?>
                            <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                             <?php
                                $de_types = \common\models\LbClientDepartments::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
                                if ($de_types != NULL) {
                                foreach ($de_types as $de_type) {
                                    if($de_type->id == $depts->department_id){
                                        $selar[$de_type->id] = array("selected"=>"selected");
                                        $prode[$de_type->id] = $de_type->department;
                                    }else{
                                        $selar[$de_type->id] ="";
                                        $prode[$de_type->id] = $de_type->department;
                                    }
                                    
                                }
                                } else {
                                    $prode = [];
                                }
                                   // echo $form->field($model, 'department_id')->dropDownList($prode, ['prompt' => 'Choose Department', 'class' => 'selectpicker','id'=>'dept-list','options'=>$selar]);
                                   echo $form->field($model, 'department_id')->dropDownList($prode, ['prompt' => 'Choose Department', 'class' => 'selectpicker','id'=>'dept-list']);
                            ?>  
                                        <input type="hidden" name="LbClientVehicles[id]" id="lbclientvehicles-id" value="<?= $depts->id; ?>">           
                        
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                             <?php
                                $de_typesv = \common\models\LbVehicleType::find()->where(['status' => 1])->all();
                                if ($de_typesv != NULL) {
                                foreach ($de_typesv as $de_typev) {
                                    if($de_typev->id == $depts->vehicle_type){
                                        $selarv[$de_typev->id] = array("selected"=>"selected");
                                        $prodev[$de_typev->id] = $de_typev->vehicle_type;
                                    }else{
                                        $selarv[$de_typev->id] ="";
                                        $prodev[$de_typev->id] = $de_typev->vehicle_type;
                                    }
                                    
                                }
                                } else {
                                    $prode = [];
                                }
                                    echo $form->field($model, 'vehicle_type')->dropDownList($prodev, ['prompt' => 'Choose Vehicle Type', 'class' => 'selectpicker','id'=>'veh-type','options'=>$selarv]);
                            ?>           
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'vehicle_number')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$depts->vehicle_number]) ?>
                                      
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
                            //$form->field($model, 'status')->dropDownList($age,['class' => 'form-control','options'=>$sel])
                            ?>
				<?= $form->field($model, 'status')->dropDownList($age,['class' => 'form-control','require'=>'required']) ?>                
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