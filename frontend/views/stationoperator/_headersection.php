    <div id="wrapper">
        <!-- header -->
        <div id="main_header" class="header-transparent" uk-sticky="top:10; cls-inactive :header-transparent">
            <header>
                <!-- Logo-->
                <i class="header-traiger uil-bars" uk-toggle="target: #wrapper ; cls: mobile-active"></i>


                <div class="h5 uk-hidden@m mr-3 mb-0"> Lootah </div>
                <!-- form search-->
                <div class="head_search uk-visible@m">
					<span>Welcome
                                        <?php 
                                        $uid=Yii::$app->session->get('stopid');
                                        $name= \common\models\LbStationOperator::find()->where(['id' => $uid])->one();
                                        echo $name->name;
                                        ?></span>
					<small>
                                            Station Operator
                                        </small>
                    <form>
                        <div class="head_search_cont">
                            <input value="" type="text" class="form-control"
                                placeholder="Search for vehicles.." autocomplete="on">
                            <i class="s_icon uil-search-alt"></i>
                        </div>

                    </form>
                </div>
                <!-- user icons -->
                <div class="head_user">
                    <!--<a href="#" class="opts_icon"> <i class="uil-bell"></i> <span>3</span> </a>-->
                    <div uk-dropdown="pos: top-right;mode:click ; animation: uk-animation-slide-bottom-small"
                        class="dropdown-notifications">
                        <div class="dropdown-notifications-headline">
                            <h4>Notifications </h4>
                        </div>
                        <div class="dropdown-notifications-content" data-simplebar>
                        </div>
                    </div>
                    <!-- profile -image -->
                    <a class="opts_account">
                    <?php
                        if($name->image){
                    ?>
                    <img src="<?= Yii::$app->request->baseUrl . '/uploads/stationoperator/' . $name->id . '/' . $name->image; ?>">
                    <?php
                        }else{
                    ?>
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/team/team-1.jpg" alt="">
                    <?php
                        }
                    ?>
                    </a>

                    <!-- profile dropdown-->
                    <div uk-dropdown="pos: top-right;mode:click ; animation: uk-animation-slide-bottom-small"
                        class="dropdown-notifications small">

                        <!-- User Name / Avatar -->
                        <a href="#">

                            <div class="dropdown-user-details">
                                <div class="dropdown-user-avatar">
                                    <?php
                                        if($name->image){
                                    ?>
                                        <img src="<?= Yii::$app->request->baseUrl . '/uploads/stationoperator/' . $name->id . '/' . $name->image; ?>">
                                    <?php
                                        }else{
                                    ?>
                                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/team/team-1.jpg" alt="">
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="dropdown-user-name">
                                    <?= $name->name; ?> <i class="uil-check"></i> </span>
                                </div>
                            </div>

                        </a>

                        <!-- User menu -->

                        <ul class="dropdown-user-menu">
                            <li><a href="<?= Yii::$app->request->baseUrl; ?>/stationoperator/profile"> <i class="uil-user"></i> My Profile </a> </li>
                            <li class="menu-divider">  </li>
                            <li><a href="<?= Yii::$app->request->baseUrl; ?>/stationoperator/logout"> <i class="icon-feather-log-out"></i> Sign Out</a> </li>
                        </ul>


                    </div>

                </div>

            </header>

        </div>