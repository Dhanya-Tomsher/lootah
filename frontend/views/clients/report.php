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

                <h2 class="text-white"> Report</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"> Dashboard </a></li>
                        <li> Report</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Search filter - Yearly / Monthly / Weekly / Daily </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <form name="frm" action="transactionsearch" method="GET">
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Department</h5>
                            </div>
                            <select class="selectpicker" name="department" id="dept-list">
                                <option value="">Department</option>
                            <?php
                                $de_types = \common\models\LbClientDepartments::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
                                if ($de_types != NULL) {
                                foreach ($de_types as $de_type) {
                            ?>
                                <option value="<?= $de_type->id; ?>"> <?= $de_type->department; ?></option>
                            <?php
                                    }
                                    }
                            ?> 
                            </select>
                        </div>                
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Vehicle</h5>
                            </div>
                            <select class="form-control" id="veh-list">
                                <option value="">Vehicle</option>
                                <?php
                                $client_odvs = \common\models\LbClientVehicles::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
                                if ($client_odvs != NULL) {
                                foreach ($client_odvs as $client_odv) {
                                ?>
                                <option value="<?= $client_odv->id; ?>"> <?= $client_odv->vehicle_number; ?></option>
                                <?php
                                }
                                }
                                ?>
                                
                            </select>                            
                        </div>									
			<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">
				<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Station</h5>
                            </div>
			<select class="selectpicker">
                            <option value="">Station</option>
                            <?php
                                $clients_odvs = \common\models\LbStation::find()->where(['status' => 1])->all();
                                if ($clients_odvs != NULL) {
                                foreach ($clients_odvs as $clients_odv) {
                                ?>
                                <option value="<?= $clients_odv->id; ?>"> <?= $clients_odv->station_name; ?></option>
                                <?php
                                }
                                }
                                ?>
                            </select>                            
                        </div>	
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Report</h5>
                        </div>
                            <input type="text" name="daterange" value="Select Date" />
                        </div>	
	<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select year</h5>
                            </div>
			<select class="selectpicker">
                                <option>2020</option>
                                <option>2021</option>
                                <option>2022</option>
                            </select>		
                        </div>	
								
	<div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mt-4 mb-4">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5></h5>
                            </div>									
            <button class="btn btn-primary btn-sm px-5 mr-2" name="Submit" type="submit">Search</button>
                                    </div>
                                  </form>
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
                                <h4>Search Results</h4>
                                <button class="btn btn-primary btn-sm px-5 mr-2" type="submit"><i class="fa fa-file-excel"></i> Export</button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Si.No.</th>
                                                <th>Date</th>
						<th>Station</th>
                                                <th>Vehicle</th>
						<th>KM</th>
						<th>Ltr's</th>
						<th>Price Inc. VAT</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i=1;
                                            $mn=date('m');
                                            $yr=date('Y');
                                            $customerprice= \common\models\LbClientMonthlyPrice::find()->where(['client_id' => Yii::$app->session->get('clid'),'month'=>$mn,'year'=>$yr])->one();
                                            $me= \common\models\LbClientVehicles::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                                            foreach($me as $mes){                                            
                                            $deps = \common\models\Transaction::find()->where(['PlateNo' => $mes->vehicle_number])->limit(10)->all();
                                            foreach($deps as $dib){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?= date('m-d-Y',strtotime($dib->StartTime)); ?></td>
                                                <td><?php $stn= \common\models\LbStation::find()->where(['id' => $dib->station_id])->one();//
                                                if(!empty($stn->station_name)){echo $stn->station_name;}else{echo "N/A";} ?></td>
                                                <td><?php $pl= \common\models\LbClientVehicles::find()->where(['id' => $dib->PlateNo])->one();//
                                                if(!empty($pl->vehicle_number)){echo $pl->vehicle_number;}else{echo "N/A";} ?></td>
						<td><?php echo $dib->Meter; ?></td>
						<td><?php echo $dib->Volume; ?></td>
						<td><?php ($dib->Volume * $customerprice->customer_price);  ?> AED</td>
                                            </tr>
                                            <?php
                                            }
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
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--> 
            
       <script type="text/javascript" src="http://localhost/biofuels/js/bootstrap-select.min.js"></script>
       <script type="text/javascript" src="http://localhost/biofuels/js/bootstrap.min.html"></script>
       <script type="text/javascript" src="http://localhost/biofuels/js/jquery-3.3.1.min.js"></script>   
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />            
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
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
