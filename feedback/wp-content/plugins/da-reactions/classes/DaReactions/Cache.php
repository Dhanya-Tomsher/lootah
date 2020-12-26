<?php
/**
 * Class Cache
 *
 * Manages all cached requests
 *
 * @package DaReactions
 *
 * @since 3.0.0
 */


namespace DaReactions;


/**
 * Class Cache
 *
 * Manages all cached requests
 *
 * @package DaReactions
 *
 * @since 3.0.0
 */
class Cache {

	/**
	 * Retrieve value from file system
	 *
	 * @param $id
	 *
	 * @return mixed|null
	 */
	public static function get( $id ) {
		$general_options = Options::getInstance( 'general' );
		if (!$general_options->getOption( 'enable_internal_cache', false )) {
			return null;
		}
		$file_path = self::getFilePath( $id );
		clearstatcache();
		if ( ! file_exists( $file_path ) ) {
			return null;
		}
		$file_ref     = fopen( $file_path, "r" );
		$file_content = fread( $file_ref, filesize( $file_path ) );

		return unserialize( $file_content );
	}

	/**
	 * Save value to file system
	 *
	 * @param $id
	 * @param $content
	 */
	public static function set( $id, $content ) {
		$general_options = Options::getInstance( 'general' );
		if (!$general_options->getOption( 'enable_internal_cache', false )) {
			return;
		}
		$file_path = self::getFilePath( $id );
		$file_ref  = fopen( $file_path, "w" );
		if ( $file_ref !== false ) {
			$file_content = serialize( $content );
			fwrite( $file_ref, $file_content );
			fclose( $file_ref );
		}
	}

	/**
	 * Delete cache file if matches strings
	 *
	 * @param $ids
	 */
	public static function delete( $ids ) {
		$base_dir = self::getBasePath();
		foreach ( glob( "$base_dir*.txt" ) as $filename ) {
			$file_parts    = explode( '.', pathinfo( $filename, PATHINFO_FILENAME ) );
			$should_delete = count( array_intersect( $ids, $file_parts ) ) > 0;
			if ( $should_delete ) {
				unlink( $filename );
				clearstatcache();
			}
		}
	}

	/**
	 * Delete all cache files
	 *
	 * @since 3.0.0
	 */
	public static function deleteAll() {
		$base_dir = self::getBasePath();
		foreach ( glob( "$base_dir*.txt" ) as $filename ) {
			unlink( $filename );
		}
		clearstatcache();
	}

	/**
	 * Return the complete path for a cache file
	 *
	 * @param $id
	 *
	 * @return string
	 */
	static function getFilePath( $id ) {
		$base_dir = self::getBasePath();
		if ( ! file_exists( $base_dir ) ) {
			mkdir( $base_dir, 0777, true );
		}
		return $base_dir . $id . '.txt';
	}

	/**
	 * Return the base path for cache files
	 *
	 * @return string
	 */
	static function getBasePath() {
		$upload_dir = wp_upload_dir();
		return $upload_dir['basedir'] . '/da-reactions/cache/';
	}

}
