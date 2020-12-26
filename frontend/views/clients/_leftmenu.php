        <!-- menu -->
        <div class="page-menu">
            <!-- btn close on small devices -->
            <span class="btn-menu-close" uk-toggle="target: #wrapper ; cls: mobile-active"></span>
            <!-- traiger btn -->
            <span class="btn-menu-trigger" uk-toggle="target: #wrapper ; cls: menu-collapsed"></span>

            <!-- logo -->
            <div class="logo uk-visible@s">
                <a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"> <img src="<?= Yii::$app->request->baseUrl; ?>/images/lootahimg.png" alt=""> </a>
            </div>
            <div class="page-menu-inner" data-simplebar>
                <ul>
                    <li class="active"><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"><i class="uil-home-alt"></i> <span> Dashboard </span></a> </li>
                </ul>
                <ul>                    
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/profile"><i class="fa fa-male"></i> <span>Profile</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/addvehicle"><i class="icon-feather-truck"></i> <span>Add Vehicle</span> </a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/adddepartment"><i class="icon-material-outline-business"></i> <span>Add Departments</span> </a> </li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/swapvehicle"><i class="icon-material-outline-compare-arrows"></i> <span> Swap Vehicle </span> </a> </li>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dailyconsumption"><i class="fa fa-oil-can"></i><span>Daily Consumption</span></a></li>
			<li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/report"><i class="icon-material-outline-description"></i> <span> Search Report </span> </a> </li>
                </ul>         
            </div>
        </div>