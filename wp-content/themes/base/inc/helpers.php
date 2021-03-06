<?php
/**
 * Helper functions for this theme.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Is the query for a non-home and non-blog page?
 *
 * @return bool
 */
function base_is_page() {
	return is_page() && ! is_front_page() && ! is_home();
}

/**
 * Get the minified file if it exists and we're on production server.
 *
 * Development environment is determined by DEV_ENV in wp-config.php.
 *
 * @param string $file File path to the minified file (assumes ".min" is in filename).
 * @return string File path
 */
function base_get_min_file( $file ) {
	// If this is a development environment or can't find minified file, use non-minified file
	if ( defined( 'DEV_ENV' ) || ! file_exists( THEME_PATH . $file ) ) {
		$file = preg_replace( '/[.-]min/', '', $file );
	}

	return $file;
}

/**
 * Insert a string into another string at a given point.
 *
 * @param string $original_string String we want to alter.
 * @param string $add_string      String we're adding.
 * @param string $find_in_string  Optional. Substring in the original string in which we're inserting new string.
 * @param bool   $insert_after    Optional. True if want to insert after $find_in_string. Default false.
 * @return string String containing the new added string.
 */
function base_add_string( $original_string, $add_string, $find_in_string = null, $insert_after = false ) {
	$offset = ( $insert_after ) ? strlen( $find_in_string ) : 0;
	$insertion_point = ( $find_in_string ) ? strpos( $original_string, $find_in_string ) + $offset : 0;
	return substr_replace( $original_string, $add_string, $insertion_point, 0 );
}
