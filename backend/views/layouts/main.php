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
      /*  width: 100% !important;*/
        margin: 10px 0px;
    }
    .profileimage img {
        width: 40px !important;
    }
    .form-control{
        display: block !important;
        width: 100% !important;
        height: 34px !important;
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
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;background:#433d2f ! important;">
                            <a href="<?= Yii::$app->request->baseUrl ?>" class="site_title">

                                <img src="<?= Yii::$app->request->baseUrl . '/images/lootah.png' ?>" style="width:100px; !important"/>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <!-- sidebar menu -->
                        <?php if (yii::$app->user->identity->role == 8) { ?>
                            <?= $this->render('_sideMenu_agent') ?>

                        <?php }
                        else { ?>
                            <?= $this->render('_sideMenu') ?>

<?php } ?>
                    </div>
                </div>

                <!-- top navigation -->
                <div class="right_coll">
                    <div class="top_nav">
                        <div class="nav_menu">
                            <nav class="" role="navigation">
                                <div class="nav toggle">
                                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                                </div>
                                <ul class="nav navbar-nav navbar-right">
                                    
                                    <li class="">
                                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <p data-letters='<?= strtoupper(yii::$app->user->identity->username[0]) ?>'  ><?= yii::$app->user->identity->username ?></p>

                                        </a>
                                        <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">                                            
                                            <li><a href="<?= Yii::$app->request->baseUrl . '/site/logout' ?>" data-method="post"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li role="presentation" class="dropdown">
                                        <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                            <li>
                                                <a>
                                                    <span class="image">
                                                        <img src="<?= Yii::$app->request->baseUrl ?>/images/img.jpg" alt="Profile Image" />
                                                    </span>
                                                    <span>
                                                        <span>John Smith</span>
                                                        <span class="time">3 mins ago</span>
                                                    </span>
                                                    <span class="message">
                                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <span class="image">
                                                        <img src="<?= Yii::$app->request->baseUrl ?>/images/img.jpg" alt="Profile Image" />
                                                    </span>
                                                    <span>
                                                        <span>John Smith</span>
                                                        <span class="time">3 mins ago</span>
                                                    </span>
                                                    <span class="message">
                                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <span class="image">
                                                        <img src="<?= Yii::$app->request->baseUrl ?>/images/img.jpg" alt="Profile Image" />
                                                    </span>
                                                    <span>
                                                        <span>John Smith</span>
                                                        <span class="time">3 mins ago</span>
                                                    </span>
                                                    <span class="message">
                                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <span class="image"><img src="<?= Yii::$app->request->baseUrl ?>/images/img.jpg" alt="Profile Image" /></span>
                                                    <span>
                                                        <span>John Smith</span>
                                                        <span class="time">3 mins ago</span>
                                                    </span>
                                                    <span class="message">
                                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="text-center">
                                                    <a>
                                                        <strong>See All Alerts</strong>
                                                        <i class="fa fa-angle-right"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                    <!-- /top navigation -->
<?= $content ?>

                </div>
            </div>

            <!-- footer content -->
            <footer>
                <div class="copyright-info">
                    <p class="pull-right">@<?php echo date("Y"); ?> Lootah Biofuels </a>
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->

        </div>
        <!-- /page content -->
    </div>
</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<?php
$this->registerJs(<<< EOT_JS_CODE

$('.alert').delay(1205000).fadeOut('slow');

        $('.del-image').click(function(){
            if (confirm('Are you sure to delete the image')) {
              return true;
            }else{
              return false;
            }
        });
        $( "#date_assignment" ).datepicker({
        dateFormat: "yy-mm-dd",

});

//   $('.clockfrom').clockpicker({
//                donetext: 'Done',
//                autoclose: true
//   });
//   $('.clockto').clockpicker({
//                donetext: 'Done',
//                autoclose: true
//   });
$( "#date_book" ).datepicker({
        dateFormat: "yy-mm-dd",
           onSelect: function(dateFrom) {
            checkavail(dateFrom);
        }
});
$( ".date_avail" ).datepicker({
        dateFormat: "yy-mm-dd",

});
$( "#date_cleaning" ).datepicker({
        dateFormat: "yy-mm-dd",

});
$( "#next_date_cleaning" ).datepicker({
        dateFormat: "yy-mm-dd",

});
$( "#date_entry" ).datepicker({
        dateFormat: "yy-mm-dd",

});
        $( "#purchase_date" ).datepicker({
        dateFormat: "yy-mm-dd",

});

$( "input[name*='BookingSearch[date]']" ).datepicker({
    dateFormat: "yy-mm-dd",

   });

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});

EOT_JS_CODE
);
?>

<?php $this->endBody() ?>
</body>


</html>
<?php $this->endPage() ?>