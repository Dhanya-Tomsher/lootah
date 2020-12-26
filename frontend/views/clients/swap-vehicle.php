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
                <h2 class="text-white"> Swap Vehicle </h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"> Dashboard </a></li>
                        <li> Swap Vehicle </li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12 ">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Details</h4>
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
                                $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'swapvehicle']);
                                $model=new \common\models\LbClientVehicleSwapRecords();
                            ?>
                                <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <?php
                                $client_odps = \common\models\LbClientDepartments::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
                                if ($client_odps != NULL) {
                                foreach ($client_odps as $client_odp) {
                                    $proo[$client_odp->id] = $client_odp->department;
                                }
                                } else {
                                    $proo = [];
                                }
                                echo $form->field($model, 'old_department')->dropDownList($proo, ['prompt' => 'Choose Department', 'class' => 'selectpicker','id'=>'dept-list','required'=>'true']);
                            ?>
	</div>
	<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <?php
            $client_odvs = \common\models\LbClientVehicles::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
            if ($client_odvs != NULL) {
                foreach ($client_odvs as $client_odv) {
                    $prov[$client_odv->id] = $client_odv->vehicle_number;
                }
            } else {
                $prov = [];
            }
            echo $form->field($model, 'old_vehicle')->dropDownList($prov, ['prompt' => 'Choose Old Vehicle', 'class' => 'form-control','id'=>'veh-list','required'=>'true']);
            ?>
        </div>
	
	<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <?php
            $client_ndvs = \common\models\LbClientVehicles::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
            if ($client_ndvs != NULL) {
                foreach ($client_ndvs as $client_ndv) {
                    $prnv[$client_ndv->id] = $client_ndv->vehicle_number;
                }
            } else {
                $prnv = [];
            }
            echo $form->field($model, 'new_vehicle')->dropDownList($prnv, ['prompt' => 'Choose New Vehicle', 'class' => 'selectpicker','required'=>'true']);
            ?>
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
                   
                   <?php
                   $deps = \common\models\LbClientVehicleSwapRecords::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                    if(count($deps)>0) {           
                   ?>
                    <div class="col-lg-12 col-xl-12 mb-3">
                        <div class="card h-lg-100">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4> Swap Records</h4>
                                
                            </div>
                            <div class="card-body pb-0">
                                <div class="media align-items-center position-relative bgd">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><b>Department</b></p>
                                    </div>                                    
                                     <div class="media-body ml-3">
                                        <p class="font-weight-semi-bold mb-0 text-500"><b>Old Vehicle</b></p>                                        
                                    </div>
				     <div class="media-body ml-3">
                                         <p class="font-weight-semi-bold mb-0 text-500"><b>New Vehicle</b></p>                                       
                                    </div>
                                     <div class="media-body ml-3">
                                         <p class="font-weight-semi-bold mb-0 text-500"><b>Date of Replacement</b></p>                                       
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                foreach($deps as $depts){
                                ?>
                                <div class="media align-items-center position-relative">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= \common\models\LbClientDepartments::find()->where(['id' =>$depts->old_department])->one()->department; ?></p>
                                    </div>                                    
                                     <div class="media-body ml-3">
                                        <p class="font-weight-semi-bold mb-0 text-500"><?php if($depts->old_vehicle){ echo \common\models\LbClientVehicles::find()->where(['id' =>$depts->old_vehicle])->one()->vehicle_number; }else{echo "N/A"; }?></p>                                        
                                    </div>
				     <div class="media-body ml-3">
                                         <p class="font-weight-semi-bold mb-0 text-500"><?php if($depts->new_vehicle){ echo \common\models\LbClientVehicles::find()->where(['id' =>$depts->new_vehicle])->one()->vehicle_number; }else{echo "N/A"; } ?></p>                                       
                                    </div>
                                     <div class="media-body ml-3">
                                         <p class="font-weight-semi-bold mb-0 text-500"><?= date('d M-Y H:i:s',strtotime($depts->date_replacement)); ?></p>                                       
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                   <?php
                   }
                   ?>
                </div>
            </div>

			
			

			
			 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>            
<script>
        $('#dept-list').change(function(){
        var dep = $('#dept-list').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/clients/get-veh",
                data: {dept_id: dep}
             }).done(function (data) {
                    $('#veh-list').html(data);
             });
  });
</script>
<style>
                .bgd{
                    background: #d7b668;
                    color: #000;
                    height: 36px;
                }
                </style>