<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'images/favicon.png',
        'css/custom.html',
        'css/style.css',
        'css/uikit.css',
        'css/bootstrap.css',
        //'css/bootstrap.min.css',
        'fonts/css/font-awesome.min.css',
//      'css/jquery-clockpicker.min.css',
        'css/animate.min.css',
        'css/custom.css',
        'css/maps/jquery-jvectormap-2.0.3.css',
        'css/icheck/flat/green.css',
        'css/croppie.css',
        'css/bootstrap-multiselect.css',
        'css/bootstrap-slider.css',
        'css/bootstrap-slider.min.css',
        'fonts/all/stylesheet.css',
        'css/style.css',
        'css/bootstrap-select.css',
        'css/developer.css',
        'css/bootstrap-colorpicker.min.css',
        'css/jquery-ui.css',
    ];
    public $js = [
        //'js/jquery-3.3.1.min.js',
        //'js/uikit.js',
        //'js/simplebar.js',
        //'js/jquery-3.3.1.min.js',
        //'js/bootstrap-select.min.js',
        //'js/bootstrap.min.html',
        'js/main.js',
        // 'js/highcharts.js',
        'js/bootstrap.min.js',
        'js/jquery-clockpicker.min.js',
        'js/nicescroll/jquery.nicescroll.min.js',
        'js/progressbar/bootstrap-progressbar.min.js',
        'js/icheck/icheck.min.js',
        'js/moment/moment.min.js',
        'js/datepicker/daterangepicker.js',
        'js/chartjs/chart.min.js',
        'js/sparkline/jquery.sparkline.min.js',
        'js/custom.js',
        'js/pace/pace.min.js',
        'js/bootstrap-datepicker.js',
        'js/gauge/gauge.min.js',
        'js/gauge/gauge_demo.js',
        'js/progressbar/bootstrap-progressbar.min.js',
        'js/nicescroll/jquery.nicescroll.min.js',
        'js/icheck/icheck.min.js',
        'js/moment/moment.min.js',
//            'js/datepicker/daterangepicker.js',
        //'js/chartjs/chart.min.js',
        'js/chart.min.js',
        'js/widget2chart.js',
        'js/custom.js',
        'js/nprogress.js',
        'js/flot/jquery.flot.js',
        'js/flot/jquery.flot.pie.js',
        'js/flot/jquery.flot.orderBars.js',
        'js/flot/jquery.flot.time.min.js',
        'js/flot/date.js',
        'js/flot/jquery.flot.spline.js',
        'js/flot/jquery.flot.stack.js',
        'js/flot/curvedLines.js',
        'js/flot/jquery.flot.resize.js',
        'js/maps/jquery-jvectormap-2.0.3.min.js',
        'js/maps/gdp-data.js',
        'js/maps/jquery-jvectormap-world-mill-en.js',
        'js/maps/jquery-jvectormap-us-aea-en.js',
        'js/skycons/skycons.min.js',
        'js/croppie.js',
        'js/common.js',
        'js/bootstrap-multiselect.js',
        'js/bootstrap-slider.js',
        'js/modernizr-fab.js',
        'js/fabric.min.js',
        'js/custom3.js',
        'js/developer.js',
//        'js/bootstrap-colorpicker.js',
        'js/jquery-ui.js',
        'js/jquery.tagsinput/src/jquery.tagsinput.js',
        'js/bootstrap-select.js'

            // 'js/bootstrap-slider.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
