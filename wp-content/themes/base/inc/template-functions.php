<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Base
 * @since 1.0.1
 */

 /**
  * Set responsive image sizes for entry featured images.
  *
  * @uses $entries_count
  *
  * @param  string       $sizes
  * @param  array|string $size
  * @return string Sizes attribute.
  */
function base_entry_image_responsive_sizes( $sizes, $size ) {
	if ( is_front_page() ) {
		global $entries_count;

		if ( 2 == $entries_count ) {
			$viewport_width = '49vw';
		} elseif ( 3 == $entries_count ) {
			$viewport_width = '32vw';
		} elseif ( 4 == $entries_count ) {
			$viewport_width = '24vw';
		// Otherwise, bail
		} else {
			return;
		}

		return '(max-width: 649px) 100vw, ' . $viewport_width;
	}
}
add_filter( 'wp_calculate_image_sizes', 'base_entry_image_responsive_sizes', 10 , 2 );

/**
 * Change excerpt length
 */
function base_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'base_excerpt_length', 999 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function base_body_classes( $classes ) {
	// Adds a class of 'hfeed' to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of 'two-column' to two-column pages.
	if ( base_has_sidebar() ) {
		$classes[] = 'two-column';
	}

	return $classes;
}
add_filter( 'body_class', 'base_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function base_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'base_pingback_header' );
