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

                <h2 class="text-white"> Change Vehicle Status</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="#"> Dashboard </a></li>
                        <li> Change Vehicle Status</li>
                    </ul>
                </nav>


               <div class="row">
                    <div class="col-12 ">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Add Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                
<form class="uk-grid-small uk-grid">
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Department </h5>
                            </div>
                <select class="selectpicker">
								<opton>Select</opton>
                                <option>Departmnet 1</option>
                                <option>Departmnet 2</option>
                            </select>
                        </div>
	
	<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Vehicle </h5>
                            </div>
                <select class="selectpicker">
								<opton>Select</opton>
                                <option>C001</option>
                                <option>C002</option>
                            </select>
                        </div>
	
	<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Status </h5>
                            </div>
                <select class="selectpicker">
								<opton>Select </opton>
                                <option>Active</option>
                                <option>Deactive</option>
                            </select>
                        </div>
                
                       	
									<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mt-4 mb-4">
										<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5></h5>
                            </div>
									
									<button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Submit</button>
                 
									</div>

                                  </form>
<div class="uk-text-success success-bx">You are successfully change the vehicle status</div>

                                </div>
                            </div>
                        </div>
                    </div>


                   

                      

                </div>
				
				
				<div class="row">
					
					 <div class="col-lg-12 col-md-12 mt-30">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Vehicle Status </h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Si.No.</th>
						<th>Vehicle</th>
                                                <th>Department</th>
                                                <th>Status</th>
						<th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                                $i=1;
                                                $deps = \common\models\LbClientVehicles::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                                                foreach($deps as $depts){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?= $depts->vehicle_number; ?></td>
                                                <td><?= \common\models\LbClientDepartments::find()->where(['id' =>$depts->department])->one()->department; ?></td>
                                                <td><?php if($depts->status == 1){echo "Active";}else{echo "Deactive";} ?></td>
						<td><a href="#modal-group-<?= $depts->id; ?>" uk-toggle uk-tooltip="Edit" class="uil-edit"></a></td>												
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
			<div id="modal-group-1" uk-modal> <div class="uk-modal-dialog"> <button class="uk-modal-close-default" type="button" uk-close></button> 				
			<div class="uk-modal-header"> <h2 class="uk-modal-title">Edit Department</h2> </div> 
				<div class="uk-modal-body"> <div class="row">                                
                        <form>
                        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Department Name</h5>
                            </div>
                <input type="text" class="form-control" placeholder="Department 1">
                        </div>
                
                       	
									<div class="col-xl-6 col-md-6 col-sm-6 col-xs-12 mt-4 mb-4">
										<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5></h5>
                            </div>
									
									<button class="btn btn-primary btn-sm px-5 mr-2" type="submit">Update</button>
                 
									</div>

                                  </form>

                                </div></div> 
				</div> </div> 