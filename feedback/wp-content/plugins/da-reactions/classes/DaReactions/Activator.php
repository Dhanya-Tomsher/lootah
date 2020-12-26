<?php
/**
 * Activator class for plugin
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */

namespace DaReactions;

/**
 * Class Activator
 * @package DaReactions
 *
 * Manage activation tasks such as initialize database and save default values
 *
 * @since 1.0.0
 */
class Activator {

	/**
	 * Invokes functions to create and populate table on plugin activation or update database if needed.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$installed_database_version = floatval( get_option( 'da_reactions_db_version', 0 ) );
		$current_database_version   = 1.0;
		if ( $installed_database_version < 1 ) {
			/// First installation ever
			self::createInitialTables();
			self::populateInitialData();
			self::setInitialOptions();
			self::createInitialFiles();
		}
		update_option( 'da_reactions_db_version', $current_database_version );
	}

	/**
	 * Creates default image files
	 * Invoked by self::activate()
	 *
	 * @since 1.0.0
	 */
	public static function createInitialFiles() {
		$source_path_with_end_slash = DA_REACTIONS_PATH . 'assets/icons/svg/_default/';
		$files                      = FileSystem::getFiles(
			$source_path_with_end_slash,
			array( 'svg', 'jpg', 'png', 'gif' ),
			true
		);

		if ( is_multisite() ) {
			$sites = get_sites();
			foreach ( $sites as $site ) {
				switch_to_blog( $site->blog_id );
				$upload_dir = wp_upload_dir();
				$path_with_end_slash = $upload_dir['basedir'] . '/da-reactions/';


				if ( ! is_dir( $path_with_end_slash ) ) {
					mkdir( $path_with_end_slash );
				}
				foreach ( $files as $file ) {
					if ( strpos( $file, '_' ) !== 0 ) {
						copy( $source_path_with_end_slash . $file, $path_with_end_slash . $file );
					}
				}

				restore_current_blog();
			}
		} else {
			$upload_dir = wp_upload_dir();
			$path_with_end_slash = $upload_dir['basedir'] . '/da-reactions/';

			if ( ! is_dir( $path_with_end_slash ) ) {
				mkdir( $path_with_end_slash );
			}
			foreach ( $files as $file ) {
				if ( strpos( $file, '_' ) !== 0 ) {
					copy( $source_path_with_end_slash . $file, $path_with_end_slash . $file );
				}
			}
		}
	}

	/**
	 * Creates tables
	 * Invoked by self::activate()
	 *
	 * @since 1.0.0
	 */
	public static function createInitialTables() {
		global $wpdb;

		if ( is_multisite() ) {
			$sites = get_sites();
			foreach ( $sites as $site ) {
				Data::createReactionsTable( $wpdb->get_blog_prefix( $site->blog_id ) );
				Data::createVotesTable( $wpdb->get_blog_prefix( $site->blog_id ) );
			}
		} else {
			Data::createReactionsTable();
			Data::createVotesTable();
		}
	}

	/**
	 * Populates tables
	 * Invoked by self::activate()
	 *
	 * @since 1.0.0
	 */
	public static function populateInitialData() {
		global $wpdb;

		if ( is_multisite() ) {
			$sites = get_sites();
			foreach ( $sites as $site ) {
				Data::createDefaultReactions( $wpdb->get_blog_prefix( $site->blog_id ) );
			}
		} else {
			Data::createDefaultReactions();
		}
	}

	/**
	 * Saves initial options
	 * Invoked by self::activate()
	 *
	 * @since 1.0.0
	 */
	public static function setInitialOptions() {
		if ( is_multisite() ) {
			$sites = get_sites();
			foreach ( $sites as $site ) {
				$general_options = Options::getInstance( 'general', $site->blog_id );
				$general_options->saveOption( "post_type_post", "on" );
				$general_options->saveOption( "post_type_post_comments", "on" );
				$general_options->saveOption( "page_type_single", "on" );
				$general_options->saveOption( "id_method_cookie", "on" );
				$general_options->saveOption( "user_can_change_reaction", "on" );
				$general_options->saveOption( "enable_internal_cache", "on" );
			}
		} else {
			$general_options = Options::getInstance( 'general' );
			$general_options->saveOption( "post_type_post", "on" );
			$general_options->saveOption( "post_type_post_comments", "on" );
			$general_options->saveOption( "page_type_single", "on" );
			$general_options->saveOption( "id_method_cookie", "on" );
			$general_options->saveOption( "user_can_change_reaction", "on" );
			$general_options->saveOption( "enable_internal_cache", "on" );
		}
	}
}
