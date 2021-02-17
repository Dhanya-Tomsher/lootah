        <!-- menu -->
        <div class="page-menu">
            <!-- btn close on small devices -->
            <span class="btn-menu-close" uk-toggle="target: #wrapper ; cls: mobile-active"></span>
            <!-- traiger btn -->
            <span class="btn-menu-trigger" uk-toggle="target: #wrapper ; cls: menu-collapsed"></span>

            <!-- logo -->
            <div class="logo uk-visible@s">
                <a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/dashboard"> <img src="<?= Yii::$app->request->baseUrl; ?>/images/lootahimg.png" alt=""> </a>
            </div>
            <div class="page-menu-inner" data-simplebar>
                <ul>
                    <li class="active"><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/dashboard"><i class="uil-home-alt"></i> <span> Dashboard </span></a> </li>
                </ul>
                <ul>                    
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/profile"><i class="fa fa-male"></i> <span>Profile</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/tankerdailycoln"><i class="fa fa-male"></i> <span>Tanker Daily Collection</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/stationdailycoln"><i class="icon-material-outline-description"></i> <span> Station Daily Collection </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/addsupplier"><i class="fa fa-male"></i> <span>Add Supplier</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/assignsupplier"><i class="icon-material-outline-description"></i> <span> Assign Supplier </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/addlpo"><i class="fa fa-male"></i> <span>Add LPO</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/tankerfillingreport"><i class="fa fa-male"></i> <span>Tanker Filling Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/calibreport"><i class="fa fa-male"></i> <span>Calibration Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/stockreport"><i class="icon-material-outline-description"></i> <span>Stock Report </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/salesreport"><i class="fa fa-male"></i> <span>Sales Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/supplierreport"><i class="icon-material-outline-description"></i> <span> Supplier Report </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/stationreport"><i class="fa fa-male"></i> <span>Station Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/tankerreport"><i class="fa fa-male"></i> <span>Tanker Report</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/bookedqtyreport"><i class="icon-material-outline-description"></i> <span> Booked Quantity Report </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/tankcleaningreport"><i class="icon-material-outline-description"></i> <span> Tank Cleaning Report </span> </a> </li>
                </ul>         
            </div>
        </div>