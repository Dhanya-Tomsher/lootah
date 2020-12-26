<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	'css/custom.html',
	'css/style.css',
	'css/uikit.css',
	'css/bootstrap.css',
	'css/icons.css'
//        'css/bootstrap.min.css',
    /*    'css/lib/css/nivo-slider.css',
        'css/core.css',
        'css/shortcode/shortcodes.css',
        'css/style.css',
        'css/responsive.css',
        'css/color/color-core.css',
        'css/plugins/slick/slick.css',
        'css/plugins/slick/slick-theme.css',
        'css/ekko-lightbox.css',
        'css/custom.css',
        'css/developer.css'*/
    ];
    public $js = [
	'js/uikit.js',
        'js/simplebar.js',
        'js/jquery-3.3.1.min.js',
        'js/bootstrap-select.min.js',
        'admin/js/bootstrap-datepicker.js',
        'js/bootstrap.min.html',
        'js/main.js',
        'js/highcharts.js',
//        'js/vendor/jquery-3.1.1.min.js',
   /*     'js/vendor/modernizr-2.8.3.min.js',
        'js/bootstrap.min.js',
        'js/lib/js/jquery.nivo.slider.js',
        'js/plugins.js',
        'js/ajax-mail.js',
        'js/main.js',
        'js/ekko-lightbox.min.js',
//        'js/ekko-lightbox.min.js.map',
        'js/custom.js'*/
    ];
    public $depends = [
        'yii\web\YiiAsset',
            //'yii\bootstrap\BootstrapAsset',
    ];

}
