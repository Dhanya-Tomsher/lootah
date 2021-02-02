<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li>
                <a href="<?= Yii::$app->request->baseUrl . '/' ?>"><i class="fa fa-th-large"></i>Dashboard</a>
            </li>

            <li>
                <a><i class="fa fa-font"></i>Admin <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">

                    <li><a href="<?= Yii::$app->request->baseUrl . '/user-admin' ?>"><i class="fa fa-font"></i>Admin Users</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/admin-role' ?>"><i class="fa fa-users"></i>Admin Roles</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-users"></i>Clients <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-clients' ?>"><i class="fa fa-user"></i>Clients</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-type' ?>"><i class="fa fa-user"></i>Client Type</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-departments' ?>"><i class="fa fa-user"></i>Client Departments</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-vehicle-type' ?>"><i class="fa fa-user"></i>Vehicle Type</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-vehicles' ?>"><i class="fa fa-user"></i>Client Vehicles</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-monthly-price' ?>"><i class="fa fa-user"></i>Client Monthly Price</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-monthly-details' ?>"><i class="fa fa-user"></i>Client Monthly Purchase Details</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-vehicle-swap-records' ?>"><i class="fa fa-user"></i>Client Vehicle Swap Records</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-container-type' ?>"><i class="fa fa-user"></i>Container Type</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-container' ?>"><i class="fa fa-user"></i>Client Container</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-client-payment-type' ?>"><i class="fa fa-user"></i>Client Payment Type</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Stations <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station' ?>"><i class="fa fa-user"></i>Stations</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/dispenser' ?>"><i class="fa fa-user"></i>Dispenser</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/nozzle' ?>"><i class="fa fa-user"></i>Nozzle</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/device' ?>"><i class="fa fa-user"></i>Device</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/transaction' ?>"><i class="fa fa-user"></i>Transaction</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-daily-station-collection' ?>"><i class="fa fa-user"></i>Daily Collection</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station-monthly-details' ?>"><i class="fa fa-user"></i>Monthly Details</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station-daily-data-for-verification' ?>"><i class="fa fa-user"></i>Daily Data Verification</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station-filling' ?>"><i class="fa fa-user"></i>Filling</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Station Operator <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-station-operator' ?>"><i class="fa fa-user"></i>Station Operator</a></li>
                    <!--<li><a href="<?= Yii::$app->request->baseUrl . '/lb-operator-station-assignment' ?>"><i class="fa fa-user"></i>Operator Station Assignment</a></li>-->
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Tankers <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tanker' ?>"><i class="fa fa-user"></i>Tankers</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-daily-tanker-collection' ?>"><i class="fa fa-user"></i>Tanker Daily Collection</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tanker-filling' ?>"><i class="fa fa-user"></i>Tanker Filling</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Tanker Operator <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tanker-operator' ?>"><i class="fa fa-user"></i>Tanker Operator</a></li>
                    <!--<li><a href="<?= Yii::$app->request->baseUrl . '/lb-operator-tanker-assignment' ?>"><i class="fa fa-user"></i>Operator Tanker Assignment</a></li>-->
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Supervisor <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-supervisor' ?>"><i class="fa fa-user"></i>Supervisor</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Area Manager <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-area-manager' ?>"><i class="fa fa-user"></i>Area Manager</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Supplier <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-supplier' ?>"><i class="fa fa-user"></i>Supplier</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-booking-to-supplier' ?>"><i class="fa fa-user"></i>Booking to Supplier</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-stock-request-management' ?>"><i class="fa fa-user"></i>Stock Request Management</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>General <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-general-settings' ?>"><i class="fa fa-user"></i>General Settings</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-gallon-litre' ?>"><i class="fa fa-user"></i>Gallon-Liter Conversion</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tank-caliberation' ?>"><i class="fa fa-user"></i>Tank Caliberation</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-tank-cleaning-report' ?>"><i class="fa fa-user"></i>Tank Cleaning Report</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/lb-physical-quantity-unit' ?>"><i class="fa fa-user"></i>Quantity Unit</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-users"></i>Report <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/site/todays' ?>"><i class="fa fa-user"></i>Todays Collection</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-globe"></i>Settings  <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                    <li><a href="<?= Yii::$app->request->baseUrl . '/configuration' ?>"><i class=" fa fa-globe"></i>Configuration</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl . '/crm-manager' ?>"><i class=" fa fa-globe"></i>API Manager</a></li>


                </ul>

            </li>
        </ul>
    </div>
</div>


