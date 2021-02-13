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

                <h2 class="text-white"> Stock Request</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> Dashboard </a></li>
			<li> Stock Request</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Stock Request </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                
                            <?php 
                            $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'stockrequest','options' => ['enctype' => 'multipart/form-data']]); 
                            $model= new \common\models\LbStockRequestManagement;
                            ?>
                                <div class="col-xl-4 col-md-4 mb-2">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Station </h5>
                                    </div>
                                    <select id="lbstockrequestmanagement-station_id" class="selectpicker" name="LbStockRequestManagement[station_id]">
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
                                
	
                            <div class="col-xl-4 col-md-4 mb-2">
                                <div class="section-headline margin-top-25 margin-bottom-12">
                                    <h5>Quantity(gal)</h5>
                                </div>                
                                    <input id="lbstockrequestmanagement-quantity" type="text" name="LbStockRequestManagement[requested_quantity_gallon]">
                            </div>
                                <div class="col-xl-4 col-md-4 mb-2">
                                    <div class="section-headline margin-top-25 margin-bottom-12">
                                        <h5>Supply Needed Date</h5>
                                    </div>                
                                    <input type="text" id="supply_needed_date" name="LbStockRequestManagement[supply_needed_date]" autocomplete="off">
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
                                <h4>Stock Request List</h4>
                                
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Station Name</th>
                                                <th>Date of request</th>
						<th>Quantity</th>
                                                <th>Assign Status</th>
                                                <th>Supply Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i=1;
                                            $firstDay7days=date('Y-m-d', strtotime('-7 days'));
                                            $LastDay7days=date('Y-m-d');
                                            $operatr= \common\models\LbStockRequestManagement::find()->where(['status'=>1])->andWhere(['between', 'date_request', $firstDay7days, $LastDay7days])->all();
                                            foreach($operatr as $operatrs){
                                        ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>												
                                                <td><?= \common\models\LbStation::find()->where(['id'=>$operatrs->station_id])->one()->station_name; ?></td>
                                                <td><?= date('Y-m-d',strtotime($operatrs->date_request)); ?></td>
                                                <td><?= round($operatrs->requested_quantity_litre,2); ?></td>
                                                <td><?php if(!empty($operatrs->assigned_date)){echo "Assigned";}else{echo "Not Assigned";} ?></td>
                                                <td><?php if($operatrs->supply_date){echo "Supplied";}else{echo "Not Supplied";} ?></td>
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