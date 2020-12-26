<?php
/**
 * A collection of utilities
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */

namespace DaReactions;

/**
 * Class Utils
 * @package DaReactions
 *
 * A collection of utilities
 *
 * @since 1.0.0
 */
class Utils {

	/**
	 * Default color palettes
	 *
	 * @var array
	 *
	 * @since 1.3.2
	 */
	public static $defaultPalette = array(
		'#95dd90',
		'#9390dd',
		'#dd9b90',
		'#90dda3',
		'#ab90dd',
		'#ddb390',
		'#90ddbb',
		'#c390dd',
		'#ddcb90',
		'#90ddd2',
		'#da90dd',
		'#d8dd90',
		'#90d0dd',
		'#dd90c8',
		'#c0dd90',
		'#90b8dd',
		'#dd90b0',
		'#a8dd90',
		'#90a0dd',
		'#dd9098'
	);

	/**
	 * Converts a number to a human readable string
	 *
	 * @param number|string $number
	 *
	 * @return bool|string
	 * @since 1.0.0
	 */
	public static function formatBigNumber( $number ) {
		$n_format = 0;
		$suffix = '';
		if ($number > 0 && $number < 1000) {
			// 1 - 999
			$n_format = floor($number);
			$suffix = '';
		} else if ($number >= 1000 && $number < 1000000) {
			// 1k-999k
			$n_format = floor($number / 1000);
			$suffix = 'K+';
		} else if ($number >= 1000000 && $number < 1000000000) {
			// 1m-999m
			$n_format = floor($number / 1000000);
			$suffix = 'M+';
		} else if ($number >= 1000000000 && $number < 1000000000000) {
			// 1b-999b
			$n_format = floor($number / 1000000000);
			$suffix = 'B+';
		} else if ($number >= 1000000000000) {
			// 1t+
			$n_format = floor($number / 1000000000000);
			$suffix = 'T+';
		}

		return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
	}

	/**
	 * Checks if a string ends with another string
	 *
	 * @param string $haystack
	 * @param string $needle
	 *
	 * @return bool
	 */
	public static function stringEndsWith( $haystack, $needle ) {
		return strrpos( $haystack, $needle ) === strlen( $haystack ) - strlen( $needle );
	}

	/**
	 * Checks if a string starts with another string
	 *
	 * @param string $haystack
	 * @param string $needle
	 *
	 * @return bool
	 */
	public static function stringStartsWith( $haystack, $needle ) {
		return strpos( $haystack, $needle ) === 0;
	}

	/**
	 * Generate a HEX color from an arbitrary string
	 * i.e. 'string' = '#84ffb4'
	 *
	 * @since 1.0.0
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function generateColorFromString( $string ) {
		$hash = md5( $string );

		$color1 = hexdec( substr( $hash, 8, 2 ) );
		$color2 = hexdec( substr( $hash, 4, 2 ) );
		$color3 = hexdec( substr( $hash, 0, 2 ) );
		if ( $color1 < 128 ) {
			$color1 += 128;
		}
		if ( $color2 < 128 ) {
			$color2 += 128;
		}
		if ( $color3 < 128 ) {
			$color3 += 128;
		}

		return "#" . dechex( $color1 ) . dechex( $color2 ) . dechex( $color3 );
	}

	/**
	 * Get contents between two delimiters
	 *
	 * @since 1.2.0
	 *
	 * @param string $string
	 * @param string $startDelimiter
	 * @param string $endDelimiter
	 *
	 * @return array
	 */
	public static function getContentsBetween( $string, $startDelimiter, $endDelimiter ) {

		$contents = array();
		$startDelimiterLength = strlen( $startDelimiter );
		$endDelimiterLength = strlen( $endDelimiter );
		$startFrom = $contentStart = $contentEnd = 0;
		while ( false !== ( $contentStart = strpos( $string, $startDelimiter, $startFrom ) ) ) {
			$contentStart += $startDelimiterLength;
			$contentEnd = strpos( $string, $endDelimiter, $contentStart );
			if ( false === $contentEnd ) {
				break;
			}
			$contents[] = substr( $string, $contentStart, $contentEnd - $contentStart );
			$startFrom = $contentEnd + $endDelimiterLength;
		}

		return $contents;

	}

	/**
	 * Returns one af the default color values
	 *
	 * @param $index
	 *
	 * @return string
	 *
	 * @since 1.3.2
	 */
	public static function getDefaultColorByIndex( $index ) {
		$count = count(self::$defaultPalette);

		return self::$defaultPalette[ $index % $count ];
	}

	/**
	 * Generate color from hex string
	 *
	 * @since 1.2.0
	 *
	 * @param resource $image
	 * @param string $hex
	 *
	 * @return int
	 */
	public static function hexColorAllocate( $image, $hex ) {
		$hex = ltrim( $hex, '#' );
		$r = hexdec(substr( $hex, 0, 2 ) );
		$g = hexdec(substr( $hex, 2, 2 ) );
		$b = hexdec(substr( $hex, 4, 2 ) );
		return imagecolorallocate( $image , $r, $g, $b );
	}

}
