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
$gal= \common\models\LbGallonLitre::find()->where(['id'=>1])->one();
$tlmt=0;
$tlms=0;
$tlmm=0;
$tcmstoday=0;
$tcmttoday=0;
$tcmt=0;
$tcms=0;
$tcmm=0;

$lpr=0;

$mn= date('m',strtotime('-1 month'));
$mnm= date('M',strtotime('-1 month'));

$yr= date('Y',strtotime('-1 month'));

$firstDayLastMonth= date("Y-$mn-01T00:00:00",strtotime('-1 month'));
$lastDayLastMonth = date("Y-$mn-tT23:59:59",strtotime('-1 month'));
$mnt= date('m');
$mntm= date('M');
$cus= \common\models\LbGeneralSettings::find()->where(['month'=>$mn])->one();
$cur= \common\models\LbGeneralSettings::find()->where(['month'=>$mnt])->one();
$firstDayCurrentMonth= date("Y-m-01T00:00:00");
$lastDayCurrentMonth = date("Y-m-tTH:i:s");
//Last month total collection

                                        $lmt= \common\models\Transaction::find()->where(['status' => 'E'])->andWhere(['between', 'StartTime', $firstDayLastMonth, $lastDayLastMonth])->all();
                                        foreach($lmt as $lmts){
                                            $tlmt +=$lmts->Volume;
                                        }
                                        $tlmm=$tlmt;
                                        
//Current month total collection
                                        $cmt= \common\models\Transaction::find()->where(['status' => 'E'])->andWhere(['between', 'StartTime', $firstDayCurrentMonth, $lastDayCurrentMonth])->all();
                                        foreach($cmt as $cmts){
                                            $tcmt +=$cmts->Volume;
                                        }
                                        $tcmm=$tcmt; 
 //Today Sale
                                        $tsrt=date('Y-m-dT00:00:00');
                                        $now=date('Y-m-dTH:i:s');
                                        $cmttoday= \common\models\Transaction::find()->where(['status' => 'E'])->andWhere(['between', 'StartTime', $tsrt, $now])->all();
                                        foreach($cmttoday as $cmttodays){
                                            $tcmttoday +=$cmttodays->Volume;
                                        }
                                        $tcmmtoday=$tcmttoday;  
                                        $firstDay7days=date('Y-m-dT00:00:00', strtotime('-7 days'));
                                        $LastDay7days=date('Y-m-dTH:i:s');
                                        $tcmt7=0;
                                        $tcms7=0;
                                       //Last 7 days sale
                                        $cmt7= \common\models\Transaction::find()->where(['status' => 'E'])->andWhere(['between', 'StartTime', $firstDay7days, $LastDay7days])->all();
                                        foreach($cmt7 as $cmts7){
                                            $tcmt7 +=$cmts7->Volume;
                                        }
                                        $tcmm7=$tcmt7;                                         
                                          
?>                                      
                                        <h6 class="card-title text-uppercase text-muted mb-2"> <?= $mntm; ?> Price </h6>                                        
                                        <span class="h4 mb-0"> <?php if($cur){ echo $cur->customer_price; ?> AED / L <br/> <?= round($cur->customer_price / $gal->litre,2); ?> AED / gal<?php } ?> </span>
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
                                        <h6 class="card-title text-uppercase text-muted mb-2"><?= $mnm; ?> Price</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0">  <?php if($cus){ echo $cus->customer_price; ?> AED / L<br/> <?= round($cus->customer_price / $gal->litre,2); ?> AED / gal<?php } ?></span>

                                        
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
                                        <h6 class="card-title text-uppercase text-muted mb-2"> Today Sale</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> <?php if($tcmmtoday){ echo $tcmmtoday; ?> in Ltr <br/>  <?= round($tcmmtoday * $gal->litre,2); ?> in gal<?php } ?></span>

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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Last 7 days sale</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0">  <?php if($tcmm7){ echo $tcmm7; ?> in Ltr <br/>  <?= round($tcmm7 / $gal->litre,2); ?> in gal<?php } ?></span>

                                        
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
                                        <h6 class="card-title text-uppercase text-muted mb-2"><?= $mntm; ?> sale</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0">   <?= $tcmm; ?> in L<br/>  <?= round($tcmm / $gal->litre,2); ?> in gal</span>

                                        
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
                                        <h6 class="card-title text-uppercase text-muted mb-2"><?= $mnm; ?> Sale</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0">  <?= $tlmm; ?> in L<br/>  <?= round($tlmm / $gal->litre,2); ?> in gal</span>

                                        
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
    <div id="container4"></div>
   
</figure>
					
					</div>
					<div class="col-xl-6 mb-3">
					
					<figure class="highcharts-figure">
    <div id="container"></div>
</figure>
					
		</div>	
					<div class="col-xl-6 mb-3">
					
					<figure class="highcharts-figure">
    <div id="container5"></div>
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
                                                <th>Sl.No.</th>
						<th>Date</th>
                                                <th>Station/Tanker</th>
                                                <th>Vehicle</th>
						<th>KM</th>
						<th>Ltrs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php            
                                                $sel= \common\models\LbStation::find()->where(['status' => 1,'supervisor'=>Yii::$app->session->get('supid')])->all();
                                                $i=1;
                                                foreach($sel as $sels){
                                                $deps = \common\models\Transaction::find()->where(['status' => 'E','station_id'=>$sels->id])->andWhere(['between', 'StartTime', $tsrt, $now])->all();                                                
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
                                                }                                                
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php
                   // }
                    ?>

            </div>
             

    </div>
   <?php
$thism=date('m');
$thisy=date('Y');
$tdy=date('Y-m-d');
?>         
<script src="<?= Yii::$app->request->baseUrl ?>/admin/js/highcharts.js"></script>
<script>
Highcharts.chart('container4', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Fuel Sale in all Stations'
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
        name: 'Litres',
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
    $det= \common\models\LbStationMonthlyDetails::find()->where(['status'=>1,'month'=>$j,'year'=>$year])->all();
    foreach($det as $dts){   
        $tot[$j] =$tot[$j]+$dts->total_sale_litre;
        }    
        echo $avg=floor($tot[$j]/$da).",";
    }
?>
        ]
    
    }]
});
</script>
		
<?php
$lamdetsz=0;
$thimdetsz=0;
$lam=date('m',strtotime('-1 month'));
$lay=date('Y',strtotime('-1 month'));
$lamdet= \common\models\LbStationMonthlyDetails::find()->where(['status'=>1,'month'=>$lam,'year'=>$lay])->all();
  foreach($lamdet as $lamdets){   
        $lamdetsz =$lamdetsz + $lamdets->total_sale_litre;
        }
$thimdet= \common\models\LbStationMonthlyDetails::find()->where(['status'=>1,'month'=>$thism,'year'=>$thisy])->all();
        foreach($thimdet as $thimdets){   
        $thimdetsz =$thimdetsz + $thimdets->total_sale_litre;
        }
?>
		
<script>
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: 'Last Month <br />Sale Comparison <br /> All Stations',
        align: 'center',
        verticalAlign: 'middle',
        y: 60
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.1f}Ltr</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'Ltr'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '75%'],
            size: '110%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Litre',
        innerSize: '50%',
        data: [
            ['Last Month', <?= $lamdetsz; ?>],
            ['Current Month', <?= $thimdetsz; ?>],
            {
                dataLabels: {
                    enabled: false
                }
            }
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
        text: 'Company Fuel Usage Current Month'
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
            text: 'Sale in (Ltr)'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Sale Today: <b>{point.y:.1f} Ltr</b>'
    },
    series: [{
        name: 'vehicle',
        data: [
<?php	
$comp=\common\models\LbClients::find()->where(['status' => 1])->all();
foreach($comp as $comps){
$sqtyz=0;
$lcmssz=0;
$tands=0;
$compz=$comps->name;
$lcms= \common\models\LbDailyStationCollection::find()->where(['status' => 1,'client_id'=>$comps->id])->all();
foreach($lcms as $lcmss){
$sqtyz=$sqtyz+$lcmss->quantity_litre;
}
$lcmst= \common\models\LbDailyTankerCollection::find()->where(['status' => 1,'client_id'=>$comps->id])->all();
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
<?php
$statnz=0;
$qtysz=0;
$sttn= \common\models\LbStation::find()->where(['status' => 1,'supervisor'=>Yii::$app->session->get('supid')])->all();
foreach($sttn as $sttnz){
$lms= \common\models\LbStationMonthlyDetails::find()->where(['status' => 1,'month'=>$thism,'year'=>$thisy,'station_id'=>$sttnz->id])->one();
if($lms){
$qtysz=$lms->total_sale_litre;
$statnz= $sttnz->station_name;      
}
}
?>		
<script>
		
		// Radialize the colors
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

// Build the chart
Highcharts.chart('container5', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Daily Fuel Selling / Station'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.1f}Ltr</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'Ltr'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.1f} Ltr',
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Usage',
        data: [
            { name: '<?= $statnz; ?>', y: <?= $qtysz; ?> },
            
        ]
    }]
});
</script>            