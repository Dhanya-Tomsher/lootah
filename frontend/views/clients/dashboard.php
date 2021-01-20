<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
        <div class="box-gradient-home"></div>
        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">
                <div class="row">					
		<div class="col-xl-12"> </div>

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
                                        $mnm= date('M',strtotime('-1 month'));
                                        $yr= date('Y',strtotime('-1 month'));
                                        $tyr=date('Y');
                                        $firstDayLastMonth= date("Y-$mn-01T00:00:00",strtotime('-1 month'));
                                        $lastDayLastMonth = date("Y-$mn-tT23:59:59",strtotime('-1 month'));
                                        $mnt= date('m');
                                        $mntm= date('M');
                                        $t= date('m');
                                        $firstDayCurrentMonth= date("Y-m-01T00:00:00");
                                        $lastDayCurrentMonth = date("Y-m-tTH:i:s");
                                        $tsrt=date('Y-m-dT00:00:00');
                                        $now=date('Y-m-dTH:i:s');
                                        $l7= date('Y-m-dT00:00:00',strtotime('-7 days'));
                                        $cus= \common\models\LbClientMonthlyPrice::find()->where(['client_id' => Yii::$app->session->get('clid'),'month'=>$mn,'year'=>$yr])->one();
                                        $custhis= \common\models\LbClientMonthlyPrice::find()->where(['client_id' => Yii::$app->session->get('clid'),'month'=>$t,'year'=>$tyr])->one();
                                        
                                        //Today's total collection
                                        $me= \common\models\LbClientVehicles::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                                        foreach($me as $mes){
                                        $custod= \common\models\Transaction::find()->where(['PlateNo' => $mes->vehicle_number])->where(['status' => 'E'])->andWhere(['between', 'StartTime', $tsrt, $now])->all();
                                        $q=0;
                                        $ql=0;
                                        $qlta=0;
                                        $qlts=0;
                                        foreach($custod as $custods){
                                            $ql +=$custods->Volume;
                                        }
                                        $q=$ql;
                                        
                                        //Last month total collection
                                        $custodtlm= \common\models\Transaction::find()->where(['PlateNo' => $mes->vehicle_number])->andWhere(['between', 'StartTime', $firstDayLastMonth, $lastDayLastMonth])->all();
                                        foreach($custodtlm as $custodtlms){
                                            $qlts +=$custodtlms->Volume;
                                        }                                        
                                        $qlta=$qlts;
                                        
                                        //This month total collection
                                        $custodtlmthis= \common\models\Transaction::find()->where(['PlateNo' => $mes->vehicle_number])->andWhere(['between', 'StartTime', $firstDayThisMonth, $lastDayThisMonth])->all();
                                        foreach($custodtlmthis as $custodtlmthiss){
                                            $qltsthis +=$custodtlmthiss->Volume;
                                        }                                        
                                        $qltathis=$qltsthis;
                                        }
                                        //Last 7 days total collection
                                        $seventhis= \common\models\Transaction::find()->where(['PlateNo' => $mes->vehicle_number])->andWhere(['between', 'StartTime', $firstDay7days, $LastDay7days])->all();
                                        foreach($seventhis as $seventhiss){
                                            $qseventhis +=$seventhiss->Volume;
                                        }
                                        $qallseven=$qseventhis;
                                            
                                    ?>                                      
                                        <h6 class="card-title text-uppercase text-muted mb-2"> <?= $mnt; ?> Price/ Ltr </h6>                                        
                                        <span class="h4 mb-0"> <?php if($custhis){ echo $custhis->customer_price; ?> AED <?php } ?> </span>
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
                                        <span class="h4 mb-0"> <?php if($custhis){ echo $custhis->discount; ?> / Ltr <?php } ?></span>

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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Today's Purchase</h6>

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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Last 7 Days Purchase</h6>

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
                                        <h6 class="card-title text-uppercase text-muted mb-2">This Month Purchase</h6>

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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Last Month Purchase</h6>

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
                                            $me= \common\models\LbClientVehicles::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
                                            foreach($me as $mes){
                                            $deps = \common\models\Transaction::find()->where(['status' => 'E','PlateNo'=>$mes->vehicle_number])->andWhere(['between', 'StartTime', $tsrt, $now])->all();                                                
                                            foreach($deps as $depts){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?= date('d-m-Y',strtotime($depts->purchase_date)); ?></td>
                                                <td><?php echo \common\models\LbStation::find()->where(['id' => $depts->station_id])->one()->station_name; ?></td>
                                                <td><?php echo $depts->PlateNo; ?></td>
						<td><?php echo $depts->Accumulator; ?></td>
						<td><?php echo $depts->Volume; ?></td>
                                            </tr>
                                            <?php
                                            $i=$i+1;
                                                } 
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

    </div>
      <script src="<?= Yii::$app->request->baseUrl; ?>/js/highcharts.js"></script>
        <script>
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Fuel Consumption'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Litres'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Fuel',
        data: [
            <?php
            
 $i=1;
$cyear=date('Y');
$cmnth=date('m');
$year=date('Y');
    $lmnth=12;
for($j=1;$j<=$lmnth;$j++){
    if($j == 1){
        $month="January";
        $da=31;
    }else if($j == 2){
        $month="February";
        $da=28;
    }else if($j == 3){
        $month="March";
        $da=31;
    }else if($j == 4){
        $month="April";
        $da=30;
    }else if($j == 5){
        $month="May";
        $da=31;
    }else if($j == 6){
        $month="June";
        $da=30;
    }else if($j == 7){
        $month="July";
        $da=31;
    }else if($j == 8){
        $month="August";
        $da=31;
    }else if($j == 9){
        $month="September";
        $da=30;
    }else if($j == 10){
        $month="October";
        $da=31;
    }else if($j == 11){
        $month="November";
        $da=30;
    }else if($j == 12){
        $month="December";
        $da=31;
    }
    $tot[$j]=0;
    $det= \common\models\Transaction::find()->where(['client_id'=>Yii::$app->session->get('clid'),'status'=>'E'])->all();
    foreach($det as $dts){   
        $tot[$j] =$tot[$j]+$dts->Volume;
        }    
        echo $avg=floor($tot[$j]/$da).",";
    }
?>
        ]    
    }]
});
</script>
		
		
		<script>
		
		Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Vehicle Fuel Consumption Last Month'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Consumption in (Ltr)'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'consumption Today: <b>{point.y:.1f} Litre</b>'
    },
    series: [{
        name: 'vehicle',
        data: [
<?php	
$lm=date('m',strtotime('-1 month'));
$ly=date('Y',strtotime('-1 month'));
$comp=\common\models\LbClientVehicles::find()->where(['client_id' => Yii::$app->session->get('clid')])->all();
foreach($comp as $comps){
$sqtyz=0;
$lcmssz=0;
$tands=0;
$compz=$comps->vehicle_number;
$lcms= \common\models\LbDailyStationCollection::find()->where(['status' => 1,'purchase_month'=>$lm,'purchase_year'=>$ly,'vehicle_id'=>$comps->id,'client_id'=>Yii::$app->session->get('clid')])->all();
foreach($lcms as $lcmss){
$sqtyz=$sqtyz+$lcmss->quantity_litre;
}
$lcmst= \common\models\LbDailyTankerCollection::find()->where(['status' => 1,'purchase_month'=>$lm,'purchase_year'=>$ly,'vehicle_id'=>$comps->id,'client_id'=>Yii::$app->session->get('clid')])->all();
foreach($lcmst as $lcmsts){
$lcmssz=$lcmssz+$lcmsts->quantity_litre;
}
$tands=$sqtyz+$lcmssz;
?>
            ['<?= $compz; ?>', <?= $tands; ?>],
         <?php
         }
         ?>
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
		</script>