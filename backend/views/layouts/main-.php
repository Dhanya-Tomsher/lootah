<style>
    body {
        background: #1e7280!important;
    }
    .nav_title {
        background: #ffffff !important;

    }
    .nav_menu {
        height: 57px!important;
    }
    .copyright-info p {
        color : #fff !important;
    }
    [data-letters]:before {
        background: #4b5532!important;
    }
    .nav.side-menu> li.active > a {

    }
    a.site_title img {
        width: 100% !important;
        margin: 10px 0px;
    }
    .profileimage img {
        width: 40px !important;
    }
    .form-control{
        display: block !important;
        width: 100% !important;
        /*height: 34px !important;*/
        padding: 6px 12px !important;
        font-size: 14px !important;
        line-height: 30px !important;
        color: #555555 !important;
        background-color: #fff !important;
        background-image: none !important;
        border: 1px solid #ccc !important;
        border-radius: 0px !important;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) ;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) !important;
        -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .label{
        display: inline-block !important;
        max-width: 100% !important;
        margin-bottom: 5px !important;
        font-weight: bold !important;
    }

</style>
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>

<?php
if (Yii::$app->session->get('lan') != null) {
    Yii::$app->language = Yii::$app->session->get('lan');
}
else {
    Yii::$app->session->set('lan', 'en');
    Yii::$app->language = Yii::$app->session->get('lan');
}
$this->title = "Lootah Biofuels"
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>

        <script type="text/javascript">
<?php /* var baseurl = "<?php print \yii\helpers\Url::base() . "/index.php/"; ?>"; */ ?>
            var baseurl = "<?php print \yii\helpers\Url::base(); ?>";

            var basepath = "<?php print \yii\helpers\Url::base(); ?>";

            var slug = function (str) {
                var $slug = '';
                var trimmed = $.trim(str);
                $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                        replace(/-+/g, '-').
                        replace(/^-|-$/g, '');
                return $slug.toLowerCase();
            };</script>

        <style>
            .profileimage img {
                width: 75px;
            }
            .tab-content {
                margin-top: 20px;
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body class="nav-md">
<?php $this->beginBody() ?>

    <div id="wrapper">
        <div id="main_header" class="header-transparent" uk-sticky="top:10; cls-inactive :header-transparent">
            <header>

                <i class="header-traiger uil-bars" uk-toggle="target: #wrapper ; cls: mobile-active"></i>
                <div class="h5 uk-hidden@m mr-3 mb-0"> Lootah </div>
                <div class="head_search uk-visible@m">
					<span>Welcome Admin</span>
					<small>Lootah</small>
                    <form>
                        <div class="head_search_cont">
                            <input value="" type="text" class="form-control"
                                placeholder="Search for Companies" autocomplete="on">
                            <i class="s_icon uil-search-alt"></i>
                        </div>

                    </form>
                </div>
                <div class="head_user">
                    <a href="#" class="opts_icon"> <i class="uil-bell"></i> <span></span> </a>

                    <!-- notificiation dropdown -->
                    <div uk-dropdown="pos: top-right;mode:click ; animation: uk-animation-slide-bottom-small"
                        class="dropdown-notifications">
                        <div class="dropdown-notifications-headline">
                            <h4>Notifications </h4>
                        </div>
                        <div class="dropdown-notifications-content" data-simplebar>
                    </div>
                    </div>
                    <a class="opts_account"> <img src="assets/images/team/team-1.jpg" alt=""></a>
                    <div uk-dropdown="pos: top-right;mode:click ; animation: uk-animation-slide-bottom-small"
                        class="dropdown-notifications small">
                        <a href="#">
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-avatar">
                                    <img src="assets/images/team/team-1.jpg" alt="">
                                </div>
                                <div class="dropdown-user-name">
                                    Admin <span>Lootah <i class="uil-check"></i> </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-user-menu">
                            <li><a href="admin-profile.html"> <i class="uil-user"></i> My Profile </a> </li>
                            <li class="menu-divider">  </li>
                            <li><a href="client-login.html"> <i class="icon-feather-log-out"></i> Sing Out</a> </li>
                        </ul>
                    </div>
                </div>
            </header>
        </div>
        <div class="page-menu">
            <!-- btn close on small devices -->
            <span class="btn-menu-close" uk-toggle="target: #wrapper ; cls: mobile-active"></span>
            <!-- traiger btn -->
            <span class="btn-menu-trigger" uk-toggle="target: #wrapper ; cls: menu-collapsed"></span>

            <!-- logo -->
            <div class="logo uk-visible@s">
                <a href="dashboard.html"> <img src="assets/images/favicon.png" alt=""> </a>
            </div>
            <div class="page-menu-inner" data-simplebar>
                 <?= $this->render('_sideMenu1'); ?>
             <!--   <ul>
                    <li class="active"><a href="superadmin-dashboard.html"><i class="uil-home-alt"></i> <span> Dashboard </span></a> </li>
                </ul>


                <ul>
                    
                    <li><a href="add-clients.html"><i class="icon-material-outline-group"></i> <span>Add Clients</span> </a></li>
					<li><a href="javascript::"><i class="icon-material-outline-add-photo-alternate"></i> <span>Manage</span> </a>
					
					<ul>
					    <li><a href="add-station.html"><i class="icon-material-outline-room"></i><span>Station</span></a></li>
						<li><a href="add-supervisor.html"><i class="icon-material-outline-person-pin"></i><span>Supervisor</span></a></li>
						<li><a href="add-tanker-operator.html"><i class="icon-material-outline-folder-shared"></i><span>Tanker Operator</span></a></li>
						<li><a href="add-station-operator.html"><i class="icon-material-outline-account-circle"></i><span>Station Operator</span></a></li>
					</ul>
					</li>
					<li><a href="javascript::"><i class="uil-moneybag"></i> <span> Daily Collection </span> </a> 
					<ul>
						<li><a href="daily-tanker-collection.html"><i class="uil-moneybag"></i><span>Tanker</span> </a></li>
						<li><a href="daily-tanker-collection.html"><i class="icon-material-outline-business"></i><span>Station</span> </a></li>
					</ul>
					</li>
					<li><a href="sales-report.html"><i class="icon-material-outline-assignment"></i> <span> Sales Report</span> </a> </li>
					<li><a href="stock-report.html"><i class="icon-material-outline-dns"></i><span>Stock Report</span></a></li>
					<li><a href="supplier-report.html"><i class="uil-invoice"></i> <span> Supplier Report</span> </a> </li>
                </ul>
-->
               

            </div>
        </div>

        <div class="box-gradient-home"></div>

        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">



                <div class="row">
					
					
                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h6 class="card-title text-uppercase text-muted mb-2"> August Price/ Ltr </h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 1.98 AED </span>


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
                                        <h6 class="card-title text-uppercase text-muted mb-2"> Current Month Sales / Ltr</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 20000 Ltr</span>

                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
										<div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="icon-feather-airplay icon-small"></i>
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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Last Month Sale / Ltr's</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 30000 Ltr</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="icon-feather-calendar icon-small"></i>
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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Appr. Margin / Ltr</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 0.50 AED</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="icon-feather-percent icon-small"></i>
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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Aug. Received Quantity / Gal.</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 10000 G</span>

                                        
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
                                        <h6 class="card-title text-uppercase text-muted mb-2">June Cash Sale Amount</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 20000 AED</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="icon-material-outline-account-balance-wallet icon-small"></i>
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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Top Consumer June</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> Consumer 1</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="icon-material-outline-account-circle icon-small"></i>
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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Avg. Purchase Cost / Aug.</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 50000 AED</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="icon-material-outline-monetization-on icon-small"></i>
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
                                        <h6 class="card-title text-uppercase text-muted mb-2">Bal. Qua. Available Supplier</h6>

                                        <!-- Heading -->
                                        <span class="h4 mb-0"> 200 G</span>

                                        
                                    </div>
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                            <i class="icon-line-awesome-truck icon-small"></i>
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
                                <h4>Todays company wise Report</h4>
                                <a href="#" class="small">View all</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Si.No.</th>
												<th>Company</th>
                                                <th>Price/ Ltr</th>
                                                <th>Ltr's</th>
												<th>Total Value</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                               
                                                <td class="name">1
                                                </td>
                                                <td>Al Reem Water</td>
                                                <td>1.85</td>
												<td>1000</td>
												<td>2500 AED</td>
                                            </tr>
                                            <tr>
                                               
                                                <td class="name">2
                                                </td>
                                               <td>Al Reem Water</td>
                                                <td>1.85</td>
												<td>1000</td>
												<td>2500 AED</td>
                                            </tr>
											<tr>
                                               
                                                <td class="name">3
                                                </td>
                                                <td>Al Reem Water</td>
                                                <td>1.85</td>
												<td>1000</td>
												<td>2500 AED</td>
                                            </tr>
											<tr>
                                               
                                                <td class="name">4
                                                </td>
                                                <td>Al Reem Water</td>
                                                <td>1.85</td>
												<td>1000</td>
												<td>2500 AED</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


               


  
             
                
               
                


            </div>

              <!-- footer
               ================================================== -->
               <div class="footer">
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-expand@s uk-first-column">
                        <p>© 2020 <strong>Lootah Biofuel System</strong>. All Rights Reserved. </p>
                    </div>
                    
                </div>
            </div>

        </div>

    </div>

    <!-- javaScripts
    ================================================== -->
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/bootstrap.min.html"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/highcharts.js"></script>

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
        data: [7000, 9000, 9500, 14000, 18000, 8000, 10000,12000, 13000, 14000, 13900, 9000]
    
    }]
});
</script>
		
	
		
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
            ['Last Month', 50000],
            ['Current Month', 48000],
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
        text: 'Daily Fuel Selling / Station'
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
            ['Station 1', 10000],
            ['Station 2', 15000],
            ['Station 3', 5000],
            ['Station 4', 7000],
            ['Station 5', 10000],
            ['Station 6', 12000]
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
        text: ' Company Fuel Usage Current Month'
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
            { name: 'Company 1', y: 1200 },
            { name: 'Company 2', y: 1500 },
            { name: 'Company 3', y: 1300 },
            { name: 'Company 4', y: 2200 },
            { name: 'Company 5', y: 1000 },
            { name: 'Company 6', y: 1100 }
        ]
    }]
});
		</script>
		
		
		
		</body>