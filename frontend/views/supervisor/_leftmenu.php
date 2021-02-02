        <!-- menu -->
        <div class="page-menu">
            <!-- btn close on small devices -->
            <span class="btn-menu-close" uk-toggle="target: #wrapper ; cls: mobile-active"></span>
            <!-- traiger btn -->
            <span class="btn-menu-trigger" uk-toggle="target: #wrapper ; cls: menu-collapsed"></span>

            <!-- logo -->
            <div class="logo uk-visible@s">
                <a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> <img src="<?= Yii::$app->request->baseUrl; ?>/images/lootahimg.png" alt=""> </a>
            </div>
            <div class="page-menu-inner" data-simplebar>
                <ul>
                    <li class="active"><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"><i class="uil-home-alt"></i> <span> Dashboard </span></a> </li>
                </ul>
                <ul>                    
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/profile"><i class="fa fa-male"></i> <span>Profile</span> </a></li>
			<!--<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/report"><i class="icon-material-outline-description"></i> <span> Search Report </span> </a> </li>-->
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/tankerdailycoln"><i class="fa fa-male"></i> <span>Tanker Daily Sales</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/stationdailycoln"><i class="icon-material-outline-description"></i> <span> Station Daily Sales </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/addstoperator"><i class="fa fa-male"></i> <span>Add Station Operator</span> </a></li>
			<!--<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/assignstation"><i class="icon-material-outline-description"></i> <span> Assign Station </span> </a> </li>-->
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/addtnoperator"><i class="fa fa-male"></i> <span>Add Tanker Operator</span> </a></li>
			<!--<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/assigntanker"><i class="icon-material-outline-description"></i> <span> Assign Tanker </span> </a> </li>-->
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/stockrequest"><i class="fa fa-male"></i> <span>Stock Request</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/physicalstockentry"><i class="icon-material-outline-description"></i> <span>Physical Stock Entry </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/supplierstockentry"><i class="fa fa-male"></i> <span>Supplier Stock Entry</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/tankcleaningreport"><i class="icon-material-outline-description"></i> <span> Tank Cleaning Report </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dispensercalib"><i class="fa fa-male"></i> <span>Dispenser Calibration</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/stockreport"><i class="icon-material-outline-description"></i> <span>Stock Report </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/salesreport"><i class="fa fa-male"></i> <span>Sales Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/supplierreport"><i class="icon-material-outline-description"></i> <span> Supplier Report </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/stationreport"><i class="fa fa-male"></i> <span>Station Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/tankerreport"><i class="fa fa-male"></i> <span>Tanker Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/bookedqtyreport"><i class="icon-material-outline-description"></i> <span> Booked Quantity Report </span> </a> </li>
                </ul>         
            </div>
        </div>