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
                <h2 class="text-white"> Tank Cleaning Report</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> Dashboard </a></li>
			<li> Add Tank Cleaning Report</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4> Add Tank Cleaning Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">                                
                            <?php 
                            $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'tankcleaning','options' => ['enctype' => 'multipart/form-data']]); 
                            $model= new \common\models\LbTankCleaningReport;
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
                                   <label class="control-label" for="station">Station</label>
				<select id="lbtankcleaningreport-station_id" class="selectpicker" name="LbTankCleaningReport[station_id]" required="required">
                                        <option value="">Select Station</option>
                                        <?php
                                        $stnz= \common\models\LbStation::find()->where(['status'=>1,'supervisor'=>Yii::$app->session->get('supid')])->all();
                                        foreach($stnz as $stnzs){
                                        ?>
                                        <option value="<?= $stnzs->id; ?>"><?= $stnzs->station_name; ?></option>
                                        <?php
                                        }
                                        ?>
                            </select> </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'date_cleaning')->textInput(['maxlength' => true,'class'=>'form-control','id'=>'date_cleaning','autocomplete'=>'off','required'=>'required']) ?>
                                </div>
                                <div class="col-xl-4 col-md-4 mb-2">
				    <?= $form->field($model, 'next_date_cleaning')->textInput(['maxlength' => true,'class'=>'form-control','id'=>'next_date_cleaning','autocomplete'=>'off','required'=>'required']) ?>
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
                                <h4> Tank Cleaning Report</h4>                                
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
                                        <p class="font-weight-semi-bold mb-0 text-500">Date of Cleaning</p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">Next Date of Cleaning</p>
                                    </div> 
                                    
                                </div>
                                <hr class="border-200 my-3">
                                <?php
                                $i=1;
                                $deps = \common\models\LbTankCleaningReport::find()->orderBy(['id' => SORT_DESC])->all();
                                foreach($deps as $depts){
                                ?>
                                <div class="media align-items-center position-relative">                                    
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500">
                                           <?= $i; ?>
                                        </p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= \common\models\LbStation::find()->where(['id'=>$depts->station_id])->one()->station_name; ?></p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->date_cleaning; ?></p>
                                    </div> 
                                    <div class="media-body ml-3">                                       
                                        <p class="font-weight-semi-bold mb-0 text-500"><?= $depts->next_date_cleaning; ?></p>
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