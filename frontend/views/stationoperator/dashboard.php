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
                                    
                                        $mn= date('m',strtotime('-1 month'));
                                        $mnt= date('M',strtotime('-1 month'));
                                        $firstDayLastMonth= date("Y-$mn-01",strtotime('-1 month'));
                                        $lastDayLastMonth = date("Y-m-t",strtotime('-1 month'));
                                        $t= date('m');
                                        $firstDayThisMonth= date("Y-m-01");
                                        $lastDayThisMonth = date("Y-m-d");
                                        
                                        $l7= date('Y-m-d',strtotime('-7 days'));
                                        $cus= \common\models\LbClientMonthlyPrice::find()->where(['client_id' => Yii::$app->session->get('clid'),'month'=>$mn])->one();
                                        
                                        //Today's total collection
                                        $custod= \common\models\LbDailyStationCollection::find()->where(['client_id' => Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                                        foreach($custod as $custods){
                                            $ql +=$custods->quantity_litre;
                                        }
                                        $custodt= \common\models\LbDailyTankerCollection::find()->where(['client_id' => Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                                        foreach($custodt as $custodst){
                                            $qlt +=$custodst->quantity_litre;
                                        }
                                        $q=$ql+$qlt; 
                                        
                                        //Last month total collection
                                        $custodtlm= \common\models\LbDailyTankerCollection::find()->where(['client_id' => Yii::$app->session->get('clid')])->andWhere(['between', 'purchase_date', $firstDayLastMonth, $lastDayLastMonth])->all();
                                        foreach($custodtlm as $custodtlms){
                                            $qlts +=$custodtlms->quantity_litre;
                                        }
                                        $custodtlmse= \common\models\LbDailyStationCollection::find()->where(['client_id' => Yii::$app->session->get('clid')])->andWhere(['between', 'purchase_date', $firstDayLastMonth, $lastDayLastMonth])->all();
                                        foreach($custodtlmse as $custodtlmss){
                                            $qltss +=$custodtlmss->quantity_litre;
                                        }
                                        $qlta=$qltss+$qlts;
                                        //This month total collection
                                        $custodtlmthis= \common\models\LbDailyTankerCollection::find()->where(['client_id' => Yii::$app->session->get('clid')])->andWhere(['between', 'purchase_date', $firstDayThisMonth, $lastDayThisMonth])->all();
                                        foreach($custodtlmthis as $custodtlmthiss){
                                            $qltsthis +=$custodtlmthiss->quantity_litre;
                                        }
                                        $custodtlmsethis= \common\models\LbDailyStationCollection::find()->where(['client_id' => Yii::$app->session->get('clid')])->andWhere(['between', 'purchase_date', $firstDayThisMonth, $lastDayThisMonth])->all();
                                        foreach($custodtlmsethis as $custodtlmsethiss){
                                            $qltssthis +=$custodtlmsethiss->quantity_litre;
                                        }
                                        $qltathis=$qltsthis+$qltssthis;
                                        
                                        //Last 7 days total collection
                                        $seventhis= \common\models\LbDailyTankerCollection::find()->where(['client_id' => Yii::$app->session->get('clid')])->andWhere(['between', 'purchase_date', $l7, $lastDayThisMonth])->all();
                                        foreach($seventhis as $seventhiss){
                                            $qseventhis +=$seventhiss->quantity_litre;
                                        }
                                        $sevensethis= \common\models\LbDailyStationCollection::find()->where(['client_id' => Yii::$app->session->get('clid')])->andWhere(['between', 'purchase_date', $l7, $lastDayThisMonth])->all();
                                        foreach($sevensethis as $sevensethiss){
                                            $qseventhisq +=$sevensethiss->quantity_litre;
                                        }
                                        $qallseven=$qseventhis+$qseventhisq;
                                            
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
                  $deps = \common\models\LbDailyStationCollection::find()->where(['client_id' => Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                   $depsp = \common\models\LbDailyTankerCollection::find()->where(['client_id' => Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                    if(count($deps) >0 || count($depsp) >0){                                                         
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
                                                <th>Station/Tanker</th>
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
                                                <td><?= date('d-m-Y',strtotime($depts->purchase_date)); ?></td>
                                                <td><?php echo \common\models\LbStation::find()->where(['id' => $depts->station_id])->one()->station_name; ?></td>
                                                <td><?php echo \common\models\LbClientVehicles::find()->where(['id' => $depts->vehicle_id])->one()->vehicle_number; ?></td>
						<td><?php echo $depts->odometer_reading; ?></td>
						<td><?php echo $depts->quantity_litre; ?></td>
                                            </tr>
                                            <?php
                                            $i=$i+1;
                                                }
                                            
                                            $j=$i+1;
                                                foreach($depsp as $deptsp){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $j; ?></td>
                                                <td><?= date('d-m-Y',strtotime($deptsp->purchase_date)); ?></td>
                                                <td><?php echo \common\models\LbTanker::find()->where(['id' => $deptsp->tanker_id])->one()->tanker_number; ?></td>
                                                <td><?php echo \common\models\LbClientVehicles::find()->where(['id' => $deptsp->vehicle_id])->one()->vehicle_number; ?></td>
						<td><?php echo $deptsp->odometer_reading; ?></td>
						<td><?php echo $deptsp->quantity_litre; ?></td>
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

              <!-- footer
               ================================================== -->
               <!--<div class="footer">
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-expand@s uk-first-column">
                        <p>© 2020 <strong>Lootah Biofuel System</strong>. All Rights Reserved. </p>
                    </div>
                    
                </div>
            </div>-->

        </div>

    </div>