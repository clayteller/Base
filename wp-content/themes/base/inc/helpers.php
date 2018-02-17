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
 * Is the query for the blog page?
 *
 * To be used when 'Homepage' and 'Posts page' are set to static pages in 'Settings > Reading'.
 *
 * @return bool
 */
function base_is_blog() {
	return is_home() && ! is_front_page();
}

/**
 * Is the query for a non-home and non-blog page?
 *
 * @return bool
 */
function base_is_page() {
	return is_page() && ! is_front_page() && ! is_home();
}

/**
 * Link to another WordPress page using the page title.
 *
 * @param string $title e.g. 'About'
 * @return string URL.
 */
function base_link_to( $title ) {
	return get_page_link( get_page_by_title( $title )->ID );
}

/**
* Get the minified file if it exists and we're on production server.
*
* @param string $file File path to the minified file (assumes ".min" is in filename).
* @return string File path
*/
function base_get_min_file( $file ) {
	// Get minified file
	if ( WP_DEBUG === false && file_exists( get_template_directory() . $file ) ) {
		$file = $file;
	// Fall back to non-minified file
	} else {
		$file = preg_replace( '/[.-]min/', '', $file );
	}
	return $file;
}

/**
 * Reads SVG file and returns it as a string.
 *
 * @param string $path Path to svg file (from theme root directory).
 * @return string SVG code.
 */
function base_inline_svg( $path ) {
	// Use @ to suppress warning if no file exists
	$file = @file_get_contents( THEME_PATH . $path  );

	// Bail if there's no file
	if ( ! $file ) return;

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
