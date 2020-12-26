<?php
/**
 * Class User
 *
 * Manages all user tasks such as identify an unregistered user by cookie
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */

namespace DaReactions;

use WP_User;

/**
 * Class User
 *
 * Manages all user tasks such as identify an unregistered user by cookie
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */
class User {

	/**
	 * @var string $plugin_name
	 * The name of the plugin
	 *
	 * @since 1.0.0
	 */
	private $plugin_name;

	/**
	 * User constructor.
	 *
	 * @param Main $main
	 *
	 * @since 1.0.0
	 */
	public function __construct( Main $main ) {

		$this->plugin_name = $main->getPluginName();

	}

	/**
	 * Save a cookie if needed
	 *
	 * @since 1.0.0
	 */
	public function setCookie() {
		$general_options = Options::getInstance( 'general' );

		if ( $general_options->getOption( 'id_method_cookie' ) === 'on' ) {
			$token = self::getUserToken();
			setcookie( 'da-reactions-token', $token, time() + 60 * 60 * 24 * 365 );
		}
	}

	/**
	 * Get the current user IP address
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function getUserIp() {
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
			$ip = $client;
		} elseif ( filter_var( $forward, FILTER_VALIDATE_IP ) ) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}

		return $ip;
	}

	/**
	 * Get a pseudo unique string token to identify a user
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function getUserToken() {
		$general_options = Options::getInstance( 'general' );

		$current_user = wp_get_current_user();
		$user_role    = self::getUserRole( $current_user );

			// Anyone may vote
			if ( $general_options->getOption( 'id_method_cookie' ) === 'on' && isset( $_COOKIE['da-reactions-token'] ) ) {
				// There is a token saved as cookie
				$token = $_COOKIE['da-reactions-token'];
			} else if ( $user_role !== 'unregistered' ) {
				// This is a logged user
				$token = md5( $current_user->ID );
			} else if ( $general_options->getOption( 'id_method_ip' ) === 'on' ) {
				// We may use IP address
				$token = md5( User::getUserIp() );
			} else {
				// No cookies
				// No IP
				// No User
				$token = md5( time() );
			}

		return $token;
	}

	/**
	 * Get user role
	 *
	 * @param WP_User $user
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function getUserRole( $user = null ) {
		$user = $user ? $user : wp_get_current_user();

		return $user->roles ? $user->roles[0] : 'unregistered';
	}

}
