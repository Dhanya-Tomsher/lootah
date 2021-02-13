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
                <h2 class="text-white"> Assign Supplier</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/dashboard"> Dashboard </a></li>
			<li> Assign Supplier</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                       
                   <?php if (Yii::$app->session->hasFlash('assusuccess')): ?>
                            <div class="alert alert-success alert-dismissable">
                            <?= Yii::$app->session->getFlash('assusuccess') ?>
                            </div>
                        <?php endif; ?>
                   <div class="col-lg-12 col-xl-12 mb-3">
                        <div class="card h-lg-100">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4> Stock Request List</h4>                                
                            </div>
                            <div class="card-body pb-0">
                                <div class="media align-items-center position-relative bgd">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Sl.No</p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Station</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Requested Quantity(gal)</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Supply Needed Date</p>
                                    </div> 
                                    <div class="uk-position-top-right uk-margin-medium-right p-3" style="top: -9px!important;">
                                        <p class="font-weight-semi-bold mb-0 text-500">Edit</p>
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                $tot=0;
                                $model=new \common\models\LbStockRequestManagement();
                                $i=1;
                                $deps = \common\models\LbStockRequestManagement::find()->where(['areamanager_approval_status'=>0])->all();
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
                                           <?php echo \common\models\LbStation::find()->where(['id' =>$depts->station_id])->one()->station_name; ?>
                                        </p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->requested_quantity_gallon; ?></p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?php echo date('d-m-Y',strtotime($depts->supply_needed_date)); ?></p>
                                    </div> 
                                    <div class="uk-position-top-right uk-margin-medium-right p-3">
                                        <a href="#modal-group-<?= $depts->id; ?>" uk-toggle  class="btn btn-icon btn-light btn-sm" uk-tooltip="Edit">
                                        <span class="uil-edit"></span> </a>
                                    </div>
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                $tot= $tot+$depts->requested_quantity_gallon;
                                $i=$i+1;
                                }
                                $gal=\common\models\LbGallonLitre::find()->where(['id' =>1])->one();
                                ?>
                                <div class="tot">Total Request : <?= round($tot,2); ?> Gallon - <?= round($tot * $gal->litre,2); ?> Litre</div>
                            </div>
                        </div>
                    </div> 
                   
                    </div>
                </div>
				           
            </div>


                        <?php
                          
                                $depsz = \common\models\LbStockRequestManagement::find()->all();
                                foreach($depsz as $deptsz){
                        ?>
			<div id="modal-group-<?= $deptsz->id; ?>" uk-modal> <div class="uk-modal-dialog"> <button class="uk-modal-close-default" type="button" uk-close></button> 				
			<div class="uk-modal-header"> <h2 class="uk-modal-title">Assign Supplier</h2> </div> 
				<div class="uk-modal-body"> <div class="row"> 
                        <?php
                        $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'assignsupplier']); 
                        ?>
                            <input type="hidden" name="LbStockRequestManagement[id]" id="lbstock-request-management-id" value="<?= $deptsz->id; ?>">    
                            <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'station_id')->textInput(['maxlength' => true,'class'=>'form-control','value'=>\common\models\LbStation::find()->where(['id' =>$deptsz->station_id])->one()->station_name]) ?>
                                </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'requested_quantity_gallon')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$deptsz->requested_quantity_gallon]) ?>
                                </div>  
                                <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'assigned_quantity_gallon')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'supply_needed_date')->textInput(['maxlength' => true,'class'=>'form-control','value'=>date('d-m-Y',strtotime($deptsz->supply_needed_date))]) ?>
                                              
                        </div>                  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?php
                                $de_types = \common\models\LbSupplier::find()->where(['status' => 1])->all();
                                if ($de_types != NULL) {
                                foreach ($de_types as $de_type) {
                                      $prode[$de_type->id] = $de_type->name;
                                   
                                }
                                } else {
                                    $prode = [];
                                }
                                    echo $form->field($model, 'supplier_id')->dropDownList($prode, ['prompt' => 'Choose Supplier', 'class' => 'selectpicker']);
                            ?> 
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
                .tot{
                    font-weight:bold;
                    float: right;
                }
                </style>