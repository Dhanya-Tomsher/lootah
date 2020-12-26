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
<ul>
                    <li class="active"><a href="superadmin-dashboard.html"><i class="uil-home-alt"></i> <span> Dashboard </span></a> </li>
                </ul>
                <ul>                    
                    			<li><a href="javascript::"><i class="icon-material-outline-add-photo-alternate"></i> <span>Admin</span> </a>
					
					<ul>
                                                <li><a href="<?= Yii::$app->request->baseUrl . '/user-admin' ?>"><i class="icon-material-outline-room"></i><span>Admin Users</span></a></li>
						<li><a href="<?= Yii::$app->request->baseUrl . '/admin-role' ?>"><i class="icon-material-outline-person-pin"></i><span>Admin Roles</span></a></li>
					</ul>
					</li>
					<li><a href="javascript::"><i class="uil-moneybag"></i> <span> Clients </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-clients' ?>"><i class="fa fa-user"></i>Clients</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-type' ?>"><i class="fa fa-user"></i>Client Type</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-departments' ?>"><i class="fa fa-user"></i>Client Departments</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-vehicle-type' ?>"><i class="fa fa-user"></i>Vehicle Type</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-vehicles' ?>"><i class="fa fa-user"></i>Client Vehicles</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-monthly-price' ?>"><i class="fa fa-user"></i>Client Monthly Price</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-vehicle-swap-records' ?>"><i class="fa fa-user"></i>Client Vehicle Swap Records</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-container-type' ?>"><i class="fa fa-user"></i>Container Type</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-container' ?>"><i class="fa fa-user"></i>Client Container</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-payment-type' ?>"><i class="fa fa-user"></i>Client Payment Type</a></li>
                                        </ul>
					</li>
                                        <li><a href="javascript::"><i class="uil-moneybag"></i> <span> Stations </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station' ?>"><i class="fa fa-user"></i>Stations</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-daily-station-collection' ?>"><i class="fa fa-user"></i>Station Daily Collection</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station-daily-data-for-verification' ?>"><i class="fa fa-user"></i>Station Daily Data Verification</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station-filling' ?>"><i class="fa fa-user"></i>Station Filling</a></li>
                                        </ul>
					</li>
                                        <li><a href="javascript::"><i class="uil-moneybag"></i> <span> Station Operator </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station-operator' ?>"><i class="fa fa-user"></i>Station Operator</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-operator-station-assignment' ?>"><i class="fa fa-user"></i>Operator Station Assignment</a></li>
                                        </ul>
					</li>
                                        <li><a href="javascript::"><i class="uil-moneybag"></i> <span> Tankers </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tanker' ?>"><i class="fa fa-user"></i>Tankers</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-daily-tanker-collection' ?>"><i class="fa fa-user"></i>Tanker Daily Collection</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tanker-filling' ?>"><i class="fa fa-user"></i>Tanker Filling</a></li>
                                        </ul>
					</li>
                                        <li><a href="javascript::"><i class="uil-moneybag"></i> <span> Tanker Operator </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tanker-operator' ?>"><i class="fa fa-user"></i>Tanker Operator</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-operator-tanker-assignment' ?>"><i class="fa fa-user"></i>Operator Tanker Assignment</a></li>
                                        </ul>
					</li>
                                        <li><a href="javascript::"><i class="uil-moneybag"></i> <span> Supervisor </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-supervisor' ?>"><i class="fa fa-user"></i>Supervisor</a></li>
                                        </ul>
					</li>
                                        <li><a href="javascript::"><i class="uil-moneybag"></i> <span> Area Manager </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-area-manager' ?>"><i class="fa fa-user"></i>Area Manager</a></li>
                                        </ul>
					</li>
                                         <li><a href="javascript::"><i class="uil-moneybag"></i> <span> Supplier </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-supplier' ?>"><i class="fa fa-user"></i>Supplier</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-booking-to-supplier' ?>"><i class="fa fa-user"></i>Booking to Supplier</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-stock-request-management' ?>"><i class="fa fa-user"></i>Stock Request Management</a></li>
                                        </ul>
                                         <li><a href="javascript::"><i class="uil-moneybag"></i> <span> General </span> </a> 
					<ul>
					    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tank-caliberation' ?>"><i class="fa fa-user"></i>Tank Caliberation</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tank-cleaning-report' ?>"><i class="fa fa-user"></i>Tank Cleaning Report</a></li>
                                        </ul>
					</li>
                                        
		                </ul>
                </div>
        </div>