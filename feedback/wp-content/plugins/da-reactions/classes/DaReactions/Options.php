<?php
/**
 * Class Options
 *
 * Manages options for various blogs and setting pages
 *
 * @package DaReactions
 */

namespace DaReactions;

/**
 * Class Options
 *
 * Manages options for various blogs and setting pages
 *
 * @package DaReactions
 */
class Options {

	/**
	 * Blog id for one instance
	 *
	 * @var int
	 *
	 * @since 1.0.0
	 */
	private $blog_id;

	/**
	 * Name for this instance
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $name;

	/**
	 * Plugin options collection
	 *
	 * @var mixed|void $options
	 *
	 * @since 1.0.0
	 */
	private $options;

	/**
	 * Plugin option identifier string
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $option_name;

	/**
	 * List of all options for all blogs
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private static $option_list;

	/**
	 * Options constructor.
	 *
	 * @param string $options_name
	 * @param int $blog_id
	 */
	function __construct( $options_name, $blog_id = null ) {
		$this->option_name = $options_name;

		if ( is_multisite() ) {
			if ( null === $blog_id ) {
				$blog_id = get_current_blog_id();
			}
			$this->blog_id = $blog_id;
			$this->options = get_blog_option( $this->blog_id, $this->option_name );
		} else {
			$this->blog_id = 0;
			$this->options = get_option( $this->option_name );
		}

		$this->name = $options_name . '_' . $blog_id;
	}

	/**
	 * Generates field name for admin settings form
	 *
	 * @param $property_name
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function getFieldName( $property_name ) {
		if ( ! empty( $property_name ) ) {
			if ( ! Utils::stringStartsWith( $property_name, '[' ) ) {
				$property_name = '[' . $property_name;
			}
			if ( ! Utils::stringEndsWith( $property_name, ']' ) ) {
				$property_name = $property_name . ']';
			}
		}

		return $this->option_name . $property_name;
	}

	/**
	 * Returns saved option object
	 *
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public function getAllOptions() {
		return $this->options;
	}

	/**
	 * Returns saved option value or a default value for a specific option
	 *
	 * @param $option_name
	 * @param string $default_value
	 *
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public function getOption( $option_name, $default_value = '' ) {
		if ( isset( $this->options[ $option_name ] ) ) {
			return $this->options[ $option_name ];
		} else {
			return $default_value;
		}
	}

	/**
	 * Save option to array
	 *
	 * @param $option_name
	 * @param string $value
	 */
	public function setOption( $option_name, $value = '' ) {
		$this->options[ $option_name ] = $value;
	}

	/**
	 * Returns plugin option identifier
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function getOptionsGroupName() {
		return $this->option_name;
	}


	/**
	 * Remove an option to database
	 *
	 * @param $option_name
	 *
	 * @since 1.0.0
	 */
	public function removeOption( $option_name ) {
		unset( $this->options[ $option_name ] );

		if ( is_multisite() ) {
			update_blog_option( $this->blog_id, $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}
	}

	/**
	 * Save a value in current options set
	 *
	 * @param $option_name
	 * @param $option_value
	 *
	 * @since 1.0.0
	 */
	public function saveOption( $option_name, $option_value ) {
		$this->options[ $option_name ] = $option_value;

		if ( is_multisite() ) {
			update_blog_option( $this->blog_id, $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}
	}

	/**
	 * Creates an instance of Options for a specific blog and name
	 *
	 * @param string $options_name
	 * @param string $options_id
	 * @param int $blog_id
	 */
	public static function createInstance( $options_name, $options_id = '', $blog_id = null ) {
		if ( null === $blog_id ) {
			if ( is_multisite() ) {
				$blog_id = get_current_blog_id();
			} else {
				$blog_id = 0;
			}
		}
		if ( empty( $options_id ) ) {
			$options_id = $options_name;
		}
		self::$option_list[ $blog_id ][ $options_id ] = new Options( $options_name, $blog_id );
	}

	/**
	 * Removes all Options instances for current blog
	 *
	 * @since 1.0.0
	 */
	public static function dropAllInstances() {
		$instances = self::getInstances();
		foreach ( $instances as $instance ) {
			self::dropInstance( $instance );
		}
	}

	/**
	 * Removes a singe instance for current blog
	 *
	 * @param $instance
	 *
	 * @since 1.0.0
	 */
	public static function dropInstance( $instance ) {
		$option_to_drop = self::getInstance( $instance );
		if ( null !== $option_to_drop ) {
			delete_option( $option_to_drop->getOptionsGroupName() );
		}
	}

	/**
	 * Get a single instance
	 *
	 * @param string $options_id
	 * @param int $blog_id
	 *
	 * @return Options
	 *
	 * @since 1.0.0
	 */
	public static function getInstance( $options_id, $blog_id = null ) {
		if ( null === $blog_id ) {
			if ( is_multisite() ) {
				$blog_id = get_current_blog_id();
			} else {
				$blog_id = 0;
			}
		}
		if ( ! isset( self::$option_list[ $blog_id ][ $options_id ] ) ) {
			self::createInstance( $options_id, $options_id, $blog_id );
		}

		return self::$option_list[ $blog_id ][ $options_id ];
	}

	/**
	 * Get all instance for a specific blog
	 *
	 * @param int $blog_id
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public static function getInstances( $blog_id = null ) {
		if ( null === $blog_id ) {
			if ( is_multisite() ) {
				$blog_id = get_current_blog_id();
			} else {
				$blog_id = 0;
			}
		}

		return array_keys( self::$option_list[ $blog_id ] );
	}
}
