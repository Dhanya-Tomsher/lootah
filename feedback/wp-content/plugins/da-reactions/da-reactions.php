<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.danielealessandra.com/
 * @since             1.0.0
 * @package           DaReactions
 *
 * @wordpress-plugin
 * Plugin Name:       Da Reactions Free
 * Plugin URI:        https://www.da-reactions-plugin.com/
 * Description:       This plugin generates reactions to let your visitors rate content and comments.
 * Version:           3.6.1
 * Author:            Daniele Alessandra
 * Author URI:        https://www.danielealessandra.com/
 * Text Domain:       da-reactions
 * Domain Path:       /languages/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 *
 * DaReactions is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * DaReactions is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DaReactions. If not, see https://www.gnu.org/licenses/gpl-2.0.txt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use DaReactions\Activator;
use DaReactions\Deactivator;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version
 *
 * @since 1.0.0
 */
define( 'DA_REACTIONS_VERSION', '3.6.1' );

/**
 * Current plugin URL
 *
 * @since 1.0.0
 */
define( 'DA_REACTIONS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Current plugin path
 *
 * @since 1.0.0
 */
define( 'DA_REACTIONS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Current plugin filename
 *
 * @since 1.0.0
 */
define( 'DA_REACTIONS_NAME', plugin_basename( __FILE__ ) );

/**
 * Current plugin directory name
 *
 * @since 1.0.0
 */
define( 'DA_REACTIONS_DIRECTORY_NAME', basename( __DIR__ ) );

/**
 * Autoload classes using PSR 0
 *
 * @since 1.0.0
 */
spl_autoload_register( function ( $class ) {
	if ( strpos( $class, 'DaReactions\\' ) === 0 ) {
		include DA_REACTIONS_PATH . 'classes/' . str_replace( '\\', '/', $class ) . '.php';
	}
} );

/**
 * The code that runs during plugin activation.
 *
 * @since 1.0.0
 */
function activateDaReactions() {
	if ( is_plugin_active( 'da-reactions/da-reactions.php' ) ) {
		die( __( 'Please disable the free version of this plugin to enable premium features.', 'da-reactions' ) );
	}
	Activator::activate();
}

register_activation_hook( __FILE__, 'activateDaReactions' );
/**
 * The code that runs during plugin deactivation.
 *
 * @since 1.0.0
 */
function deactivateDaReactions() {
	Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivateDaReactions' );

if ( ! function_exists( 'runDaReactions' ) ) {
	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function runDaReactions() {
		$plugin = new DaReactions\Main();
		$plugin->run();
	}
}

runDaReactions();
