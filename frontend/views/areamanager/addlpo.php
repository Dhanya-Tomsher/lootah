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
                <h2 class="text-white"> Add LPO</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/dashboard"> Dashboard </a></li>
			<li> Add LPO</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Add LPO </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">                                
                            <?php 
                            $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'addlpo','options' => ['enctype' => 'multipart/form-data']]); 
                            $model= new \common\models\LbBookingToSupplier();
                            ?>
                                    <div class="col-xl-12 col-md-12">
                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success alert-dismissable">
                            <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                        <?php endif; ?>
                         <?php if (Yii::$app->session->hasFlash('edsuccess')): ?>
                            <div class="alert alert-success alert-dismissable">
                            <?= Yii::$app->session->getFlash('edsuccess') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger alert-dismissable">
                            <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php endif; ?>
                                        </div>
                                <div class="col-xl-4 col-md-4 mb-2">
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
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'lpo_date')->textInput(['maxlength' => true,'class'=>'form-control','autocomplete'=>'off']) ?>
                                </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'price_per_gallon')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'lpo')->fileInput(['maxlength' => true,'class'=>'form-control']) ?>
                                </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'booked_quantity_gallon')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
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
                                <h4> Supplier LPO</h4>                                
                            </div>
                            <div class="card-body pb-0">
                                <div class="media align-items-center position-relative bgd">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Sl.No</p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Supplier</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">LPO Date</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Rate/gal</p>
                                    </div>
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Booked Quantity</p>
                                    </div>
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">LPO</p>
                                    </div>
                                    
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                $i=1;
                                $deps = \common\models\LbBookingToSupplier::find()->orderBy(['id' => SORT_DESC])->all();
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
                                           <?= common\models\LbSupplier::find()->where(['id' => $depts->supplier_id])->one()->name; ?>
                                        </p>
                                    </div>  
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= date('d-m-Y',strtotime($depts->lpo_date)); ?></p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->price_per_gallon; ?></p>
                                    </div>
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->booked_quantity_gallon; ?></p>
                                    </div>
                                    <div class="media-body ml-3">
                                        <?php
                                        if($depts->lpo){
                                            ?>                                        
                                        <p class="font-weight-semi-bold mb-0 text-500"><img src="<?= Yii::$app->request->baseUrl . '/uploads/lpo/' . $depts->id . '/' . $depts->lpo; ?>" width="100" height="100"></p>
                                        <?php
                                        }
                                        ?>
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


 <style>
                .bgd{
                    background: #d7b668;
                    color: #000;
                    height: 36px;
                }
                </style>