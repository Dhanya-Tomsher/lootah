<?php
use WP_Reactions\Lite\Main;

/*
Plugin Name: WP Reactions Lite
Description: The #1 Emoji Reactions Plugin for Wordpress. Engage your users with Lottie animated emoji reactions and increase social sharing with mobile and desktop sharing pop-ups and surprise button reveals. Put your emojis anywhere you want to get a reaction.
Plugin URI: https://wpreactions.com
Version: 1.0.4
Requires at least: 4.4
Requires PHP: 5.3
Author: WP Reactions, LLC
Text Domain: wpreactions-lite
*/

define( 'WPRA_LITE_VERSION', '1.0.3' );
define( 'WPRA_LITE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPRA_LITE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPRA_LITE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPRA_LITE_OPTIONS', 'wpra_lite_options' );

require_once( WPRA_LITE_PLUGIN_PATH . 'includes/helper.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/configuration.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/wp-helper-extension.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/activation.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/field-manager.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/admin-pages.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/shortcode.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/metaboxes.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/ajax-handler.class.php' );
require_once( WPRA_LITE_PLUGIN_PATH . 'includes/wpreactions-main.class.php' );

// init plugin
global $wpra_lite;
$wpra_lite = new Main();
