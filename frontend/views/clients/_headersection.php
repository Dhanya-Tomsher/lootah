    <div id="wrapper">
        <!-- header -->
        <div id="main_header" class="header-transparent" uk-sticky="top:10; cls-inactive :header-transparent">
            <header>
                <!-- Logo-->
                <i class="header-traiger uil-bars" uk-toggle="target: #wrapper ; cls: mobile-active"></i>


                <div class="h5 uk-hidden@m mr-3 mb-0"> Lootah </div>
                <!-- form search-->
                <div class="head_search uk-visible@m">
					<span>Welcome</span>
					<small>
                                        <?php 
                                        $uid=Yii::$app->session->get('clid');
                                        $sup= \common\models\LbClients::find()->where(['id' => $uid])->one();
                                        $name=$sup->name;
                                        echo $name;
                                        ?>
                                        </small>
                    <form>
                        <div class="head_search_cont" style="height:36px;">&nbsp;
                            <!--<input value="" type="text" class="form-control"
                                placeholder="Search for vehicles.." autocomplete="on">
                            <i class="s_icon uil-search-alt"></i>-->
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
                                if($sup->profile_image){
                            ?>
                                <img src="<?= Yii::$app->request->baseUrl . '/uploads/clients/' . $sup->id . '/' . $sup->profile_image; ?>"
                                              alt="avatar" width="100" height="100">
                                    
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
                                if($sup->profile_image){
                            ?>
                                <img src="<?= Yii::$app->request->baseUrl . '/uploads/clients/' . $sup->id . '/' . $sup->profile_image; ?>"
                                              alt="avatar" width="100" height="100">
                                    
                            <?php
                                }else{
                            ?>
                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/team/team-1.jpg" alt="">
                            <?php
                                }
                            ?>
                                </div>
                                <div class="dropdown-user-name">
                                    <?= $name; ?> <i class="uil-check"></i> </span>
                                </div>
                            </div>

                        </a>

                        <!-- User menu -->

                        <ul class="dropdown-user-menu">
                            <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/profile"> <i class="uil-user"></i> My Profile </a> </li>
                            <li class="menu-divider">  </li>
                            <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/logout"> <i class="icon-feather-log-out"></i> Sign Out</a> </li>
                        </ul>


                    </div>

                </div>

            </header>

        </div>