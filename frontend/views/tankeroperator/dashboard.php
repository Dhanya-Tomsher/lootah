<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
        <div class="box-gradient-home"></div>
        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">
                <div class="row">					
		<div class="col-xl-12">												
						</div>

                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                    <?php
                                    $ql=0;
                                    $qlt=0;
                                    $qlts=0;
                                    $qltss=0;
                                    $qltsthis=0;
                                    $qltssthis=0;
                                    $qseventhis=0;
                                    $qseventhisq=0;
                                    
                                        $mn= date('m');
                                        $mnt= date('M');
                                        
                                        $mnl= date('m',strtotime('-1 month'));
                                        $mntl= date('M',strtotime('-1 month'));
                                        
                                        $firstDayLastMonth= date("Y-$mnl-01T00:00:00",strtotime('-1 month'));
                                        $lastDayLastMonth = date("Y-m-tT23:59:59",strtotime('-1 month'));
                                        $t= date('m');
                                        $firstDayThisMonth= date("Y-m-01T00:00:00");
                                        $lastDayThisMonth = date("Y-m-dT23:59:59");
                                        
                                        $l7= date('Y-m-d',strtotime('-7 days'));
                                        $cus= \common\models\LbGeneralSettings::find()->where(['month'=>$mn])->one();
                                        $tankero= \common\models\LbTankerOperator::find()->where(['id'=>Yii::$app->session->get('tanopid')])->one();
                                        $tanker=\common\models\LbTanker::find()->where(['id'=>$tankero->tanker])->one();
                                        //Today's total collection
                                        $custod= \common\models\Transaction::find()->where(['Meter'=>$tanker->tanker_number,'StartTime'=>date('Y-m-dTH:i:s')])->all();
                                        foreach($custod as $custods){
                                            $ql +=$custods->Volume;
                                        }
                                        
                                        $q=$ql; 
                                        
                                        //Last month total collection
                                        $custodtlm= \common\models\Transaction::find()->where(['Meter'=>$tanker->tanker_number])->andWhere(['between', 'StartTime', $firstDayLastMonth, $lastDayLastMonth])->all();
                                        foreach($custodtlm as $custodtlms){
                                            $qlts +=$custodtlms->Volume;
                                        }
                                        $qlta=$qlts;
                                        //This month total collection
                                        $custodtlmthis= \common\models\Transaction::find()->where(['Meter'=>$tanker->tanker_number])->andWhere(['between', 'StartTime', $firstDayThisMonth, $lastDayThisMonth])->all();
                                        foreach($custodtlmthis as $custodtlmthiss){
                                            $qltsthis +=$custodtlmthiss->Volume;
                                        }
                                        $qltathis=$qltsthis;
                                        
                                        //Last 7 days total collection
                                        $seventhis= \common\models\Transaction::find()->where(['Meter'=>$tanker->tanker_number])->andWhere(['between', 'StartTime', $l7, $lastDayThisMonth])->all();
                                        foreach($seventhis as $seventhiss){
                                            $qseventhis +=$seventhiss->quantity_litre;
                                        }
                                        $qallseven=$qseventhis;
                                            
                                    ?>                                      
                                        <h6 class="card-title text-uppercase text-muted mb-2"> <?= $mnt; ?> Price/ Ltr </h6>                                        
                                        <span class="h4 mb-0"> <?php if($cus){ echo $cus->customer_price; ?> AED <?php } ?> </span>
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="uil-pricetag-alt icon-small"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
					
					<div class="col-md-4 col-lg-4 col-xl-4">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h6 class="card-title text-uppercase text-muted mb-2"> Discounted Price / Ltr</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> <?php if($cus){ echo $cus->discount; ?> / Ltr <?php } ?></span>

                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
										<div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="uil-label-alt icon-small"></i>
                                        </div>
                                       

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h6 class="card-title text-uppercase text-muted mb-2">Today So Far</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> <?= $q; ?> Ltr</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="uil-invoice icon-small"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
					
			<div class="col-md-4 col-lg-4 col-xl-4">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h6 class="card-title text-uppercase text-muted mb-2">Last 7 Days</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> <?= $qallseven; ?> Ltr</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="uil-water-glass icon-small"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
					
					<div class="col-md-4 col-lg-4 col-xl-4">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h6 class="card-title text-uppercase text-muted mb-2">This Month</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> <?= $qltathis; ?> Ltr</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="uil-raindrops-alt icon-small"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

					<div class="col-md-4 col-lg-4 col-xl-4">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h6 class="card-title text-uppercase text-muted mb-2">Last Month</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> <?= $qlta; ?> Ltr</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="uil-raindrops-alt icon-small"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
					
					<div class="col-xl-12">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h6 class="card-title text-uppercase text-muted mb-2">Carbon Emission Report</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 10%</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <span class="icon-feather-cloud-snow icon-small"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
					
					
					<div class="col-xl-12 mb-3">
					
				<figure class="highcharts-figure">
    <div id="container"></div>
   
</figure>
					
					</div>
					 
					<div class="col-xl-12 mb-3">
					<figure class="highcharts-figure">
                                        <div id="container2"></div>
                                        </figure></div>
					
					

                </div>

              <div class="row">	
                  <?php
                  $deps = \common\models\Transaction::find()->where(['Meter'=>$tanker->tanker_number,'StartTime'=>date('Y-m-dTH:i:s')])->all();
                  if(count($deps) >0){                                                         
                  ?>
			<div class="col-lg-12 col-md-12 mt-30">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Today's Fuel Consumption</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Si.No.</th>
						<th>Date</th>
                                                <th>Tanker</th>
                                                <th>Vehicle</th>
						<th>KM</th>
						<th>Ltr's</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                                foreach($deps as $depts){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?= date('d-m-Y',strtotime($depts->StartTime)); ?></td>
                                                <td><?php echo \common\models\LbStation::find()->where(['id' => $depts->station_id])->one()->station_name; ?></td>
                                                <td><?php echo $depts->PlateNo; ?></td>
						<td><?php echo $depts->Accumulator; ?></td>
						<td><?php echo $depts->Volume; ?></td>
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
                  <?php
                    }
                    ?>
            </div>             
        </div>

    </div>