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
 * Is $type the current post type?
 *
 * @param string $type e.g. 'post'
 * @return bool True if $type is the current post type.
 */
function base_is_post_type( $type ) {
	return $type == get_post_type();
}

/**
 * Is the query for the posts page (when 'Homepage' and 'Posts page' are static pages)?
 *
 * @return bool True if 'Posts page' is a static page.
 */
function base_is_blog() {
	return is_home() && ! is_front_page();
}

/**
 * Are we displaying a sidebar on this page?
 *
 * @return bool True if 'show_sidebar' custom field is true.
 */
function base_has_sidebar() {
	return get_field( 'show_sidebar' );
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
* Add inline CSS to display a background image.
*
* @param string $css_class          CSS class of element being assigned a background image.
* @param string $field_name         Field name of background image custom field.
* @param bool   $field_name_post_id Optional. Post id of custom field.
* @return string Inline CSS rules.
*/
function base_get_background_image_css( $css_class, $field_name, $field_name_post_id = false ) {
	// If there's no 'page' background image, use the 'site' background image
	$image = get_field( $field_name, $field_name_post_id ) ? get_field( $field_name, $field_name_post_id ) : get_field( $field_name, 'option' );

	// Bail if there's no image
	if ( ! $image ) return;

	// Image size for small screens
	$image_url = $image['sizes'][ 'medium_large' ];
	// Image size for desktop screens
	$image_url_desktop = $image['url'];

	return "
	.{$css_class} {
		background-image: url({$image_url});
	}
	@media (min-width: 768px) {
		.{$css_class} {
			background-image: url({$image_url_desktop});
		}
	}";
}

/**
 * Reads SVG icon file and returns it as a string.
 *
 * @param string $name Name of icon file.
 * @return string SVG code.
 */
function base_svg_icon( $name ) {
	// Use @ to suppress warning if no file exists
	$file = @file_get_contents( THEME_PATH . '/icons/' . $name . '.svg' );

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
