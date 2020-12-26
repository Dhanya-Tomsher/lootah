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

                <h2 class="text-white">Physical Stock Entry</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> Dashboard </a></li>
			<li>Physical Stock Entry</li>
                    </ul>
                </nav>
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
                                                <th>Date of entry</th>
						<th>Physical Stock(Gal)</th>
                                                <th>Stock by Calculation(Gal)</th>
                                                <th>Stock Difference</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i=1;
                                            $firstDay7days=date('Y-m-d', strtotime('-7 days'));
                                            $LastDay7days=date('Y-m-d');
                                            $operatr= \common\models\LbStationDailyDataForVerification::find()->where(['status'=>1])->andWhere(['between', 'date_entry', $firstDay7days, $LastDay7days])->all();
                                            foreach($operatr as $operatrs){
                                        ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>												
                                                <td><?= \common\models\LbStation::find()->where(['id'=>$operatrs->station_id])->one()->station_name; ?></td>
                                                <td><?= date('Y-m-d',strtotime($operatrs->date_entry)); ?></td>
                                                <td><?php if(!empty($operatrs->physical_stock)){echo round($operatrs->physical_stock,2);} ?></td>
                                                <td><?php if(!empty($operatrs->stock_by_calculation)){echo round($operatrs->stock_by_calculation,2);} ?></td>
                                                <td><?php if(!empty($operatrs->stock_difference)){echo round($operatrs->stock_difference,2);} ?></td>
                                                <td>
                                                    <?php if(!empty($operatrs->physical_stock)){
                                                    echo "N/A";
                                                    }else{
                                                        ?> 
                                                <a href="#modal-group-<?= $operatrs->id; ?>" uk-toggle  class="btn btn-icon btn-light btn-sm" uk-tooltip="Edit">
                                                <span class="uil-edit"></span> </a>
                                                <?php
                                                       
                                                    }
                                                    ?>
                                                </td>
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
                        <?php
                            $deps = \common\models\LbStationDailyDataForVerification::find()->where(['status' => 1])->all();
                            foreach($deps as $depts){
                        ?>
			<div id="modal-group-<?= $depts->id; ?>" uk-modal> <div class="uk-modal-dialog"> <button class="uk-modal-close-default" type="button" uk-close></button> 				
			<div class="uk-modal-header"> <h2 class="uk-modal-title">Physical Stock Entry (Gal)</h2> </div> 
				<div class="uk-modal-body"> 
                                    <div class="row"> 
                        <?php
                        $form = ActiveForm::begin(['enableClientScript' => false,'class'=>'uk-grid-small uk-grid','action'=>'physicalstockentry','options' => ['enctype' => 'multipart/form-data']]); 
                        $model= \common\models\LbStationDailyDataForVerification::find()->where(['id'=>$depts->id])->one();
                        $st = \common\models\LbStation::find()->where(['id'=>$depts->station_id])->one()->station_name;
                        
                        ?>
                        <input type="hidden" name="LbStationDailyDataForVerification[id]" id="LbStationDailyDataForVerification-id" value="<?= $depts->id; ?>">    
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'station_id')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$st,'readonly'=>'readonly']) ?>
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'stock_by_calculation')->textInput(['maxlength' => true,'class'=>'form-control','value'=>round($depts->stock_by_calculation,2),'readonly'=>'readonly']) ?>
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <?= $form->field($model, 'physical_stock')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$depts->physical_stock]) ?>
                        </div>  
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mt-4 mb-4">
				<div class="section-headline margin-top-25 margin-bottom-12">
                                    <h5></h5>
                                </div>									
				<button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Update</button>                 
			</div>
                        <?php ActiveForm::end(); ?>
                                </div>
                                </div> 
				</div> 
                        </div> 
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