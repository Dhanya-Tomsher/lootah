        <!-- menu -->
        <div class="page-menu">
            <!-- btn close on small devices -->
            <span class="btn-menu-close" uk-toggle="target: #wrapper ; cls: mobile-active"></span>
            <!-- traiger btn -->
            <span class="btn-menu-trigger" uk-toggle="target: #wrapper ; cls: menu-collapsed"></span>

            <!-- logo -->
            <div class="logo uk-visible@s">
                <a href="<?= Yii::$app->request->baseUrl; ?>/tankeroperator/dashboard"> <img src="<?= Yii::$app->request->baseUrl; ?>/images/lootahimg.png" alt=""> </a>
            </div>
            <div class="page-menu-inner" data-simplebar>
                <ul>
                    <li class="active"><a href="<?= Yii::$app->request->baseUrl; ?>/tankeroperator/dashboard"><i class="uil-home-alt"></i> <span> Dashboard </span></a> </li>
                </ul>
                <ul>                    
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/tankeroperator/profile"><i class="fa fa-male"></i> <span>Profile</span> </a></li>
		</ul>         
            </div>
        </div>