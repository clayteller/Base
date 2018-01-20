<?php
/**
 * Helper functions for this theme.
 *
 * @package Base
 * @since 1.0.1
 */

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
 * @return bool True if we're displaying a sidebar.
 */
function base_has_sidebar() {
	return get_field( 'show_sidebar' ) || is_page( 'contact' );
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
 * Require SVG icon file.
 *
 * @param string $name Name of icon.
 */
function base_svg_icon( $name ) {
	require THEME_PATH . '/icons/' . $name . '.svg';
}
