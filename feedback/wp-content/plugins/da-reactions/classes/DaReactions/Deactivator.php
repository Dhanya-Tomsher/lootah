<?php
/**
 * Class Deactivator
 *
 * @since 1.0.0
 */


namespace DaReactions;

/**
 * Class Deactivator
 * @package DaReactions
 *
 * Manage deactivation tasks such as cleaning database and delete options
 *
 * @since 1.0.0
 */
class Deactivator {

	/**
	 * Invokes functions to delete tables on plugin deactivation if needed.
	 *
	 * @since 1.0.0
	 */
	public static function deactivate() {
		$general_options = Options::getInstance( 'general' );

		$remove_data = $general_options->getOption( 'remove_data_on_disable' ) === 'on';

		if ( $remove_data ) {
			self::removeTables();
			Cache::deleteAll();
		}
	}

	/**
	 * Delete tables and options from database
	 *
	 * @since 1.0.0
	 */
	public static function removeTables() {
		global $wpdb;

		/// When the plugin is disabled autoload will no work
        if ( !class_exists( 'Data' ) ) {
            require_once "Data.php";
        }
        if ( !class_exists( 'FileSystem' ) ) {
            require_once "FileSystem.php";
        }

		if ( is_multisite() ) {
			$sites = get_sites();
			foreach ( $sites as $site ) {
				Data::dropTables( $wpdb->get_blog_prefix( $site->blog_id ) );
				delete_option( 'da-reactions_general' );
				delete_option( 'da-reactions_buttons' );
				delete_option( 'da-reactions_graphic' );
			}
		} else {
			Data::dropTables();
			delete_option( 'da-reactions_general' );
			delete_option( 'da-reactions_buttons' );
			delete_option( 'da-reactions_graphic' );
		}
		delete_option( "da_reactions_db_version" );

		// clean files
		FileSystem::deleteAllImages();
	}

}
