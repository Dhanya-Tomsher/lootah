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
        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">

                <h2 class="text-white"> Assign Station Operator</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> Dashboard </a></li>
			<li> Assign Station to Operator</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Assign Station Operator Details </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                
                            <?php 
                            $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'opetatortostn','options' => ['enctype' => 'multipart/form-data']]); 
                            ?>
                                <div class="col-xl-4 col-md-4 mb-2">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5> Name</h5>
                                    </div>
                                    <select id="lboperatorstationassignment-operator_id" class="selectpicker" name="LbOperatorStationAssignment[operator_id]">
                                        <option value="">Select Operator</option>
                                        <?php
                                        $stn= \common\models\LbStationOperator::find()->where(['status'=>1])->all();
                                        foreach($stn as $stns){
                                        ?>
                                        <option value="<?= $stns->id; ?>"><?= $stns->name; ?>(<?= $stns->username; ?>)</option>
                                        <?php
                                        }
                                        ?>
                                    </select>                            
                                </div>
                                
	
                            <div class="col-xl-4 col-md-4 mb-2">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Station</h5>
                            </div>
                
                            <select id="lboperatorstationassignment-station_id" class="selectpicker" name="LbOperatorStationAssignment[station_id]">
                                        <option value="">Select Station</option>
                                        <?php
                                        $stnz= \common\models\LbStation::find()->where(['status'=>1,'supervisor'=>Yii::$app->session->get('supid')])->all();
                                        foreach($stnz as $stnzs){
                                        ?>
                                        <option value="<?= $stnzs->id; ?>"><?= $stnzs->station_name; ?></option>
                                        <?php
                                        }
                                        ?>
                            </select> 
                        </div>
                        <div class="col-xl-2 col-md-2 col-sm-6 col-xs-12 mt-4 mb-2">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5></h5>
                            </div>
									
                            <button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Submit</button>
                 
									</div>

                                  <?php ActiveForm::end(); ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
					
					 <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Station Operator List</h4>
                                
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Station Name</th>
						<th>Operator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i=1;
                                            $operatr= \common\models\LbStation::find()->where(['status'=>1])->all();
                                            foreach($operatr as $operatrs){
                                        ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>												
                                                <td><?= $operatrs->station_name; ?></td>
                                                <td><?php if($operatrs->operator){ echo \common\models\LbStationOperator::find()->where(['id'=>$operatrs->operator])->one()->name;} ?></td>
                                            </tr>                                                                                        			
					<?php
                                           $i=$i+1;
                                           }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>