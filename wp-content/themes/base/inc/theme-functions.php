<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

 /**
 * Include files
 */
 foreach ( glob( plugin_dir_path( __FILE__ ) . "theme-functions/*.php" ) as $file ) {
 	require $file;
 }

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
 * Add a 'Read more' link to the excerpt.
 */
function base_excerpt( $excerpt ) {
	return $excerpt . ' <a href="' . get_permalink() . '" class="more-link">' . __( 'Read more', 'base' ) . '</a>';
}
add_filter( 'get_the_excerpt', 'base_excerpt' );

/**
 * Change excerpt length.
 */
function base_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'base_excerpt_length', 999 );

/**
 * Change excerpt ellispis.
 */
function base_excerpt_more( $more ) {
	return '…';
}
add_filter( 'excerpt_more', 'base_excerpt_more' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function base_body_classes( $classes ) {
	$show_subscribe = get_field( 'show_subscribe', 'option' );

	// Adds a class of 'hfeed' to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of 'two-column' to two-column pages.
	if ( base_has_sidebar() || is_page( 'contact' ) ) {
		$classes[] = 'two-column';
	}

	// Adds a class of 'has-subscribe' to pages with subscribe form.
	if ( $show_subscribe ) {
		$classes[] = 'has-subscribe';
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
