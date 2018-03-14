<?php
/**
 * Set responsive image sizes
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Set responsive image sizes for entry featured images.
 *
 * @uses global $entries_count How many entries are being displayed.
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string Value to use in image 'sizes' attribute.
 */
function base_responsive_image_sizes( $sizes, $size ) {
	/**
	 * Breakpoint at which the image width changes.
	 *
	 * @var string
	 */
	$breakpoint = '559px';

	/**
	 * Image width in small screen layouts.
	 *
	 * @var string
	 */
   $width_small_screen  = '100vw';

	/**
	 * Image width in large screen layouts.
	 *
	 * @var string
	 */
	$width_large_screen = '100vw';

	// Services post type
   if ( 'service' === get_post_type() ) {
      $width_small_screen = '100px';
      $width_large_screen = '140px';

	// Testimonial post type
	} elseif ( 'testimonial' === get_post_type() ) {
      $width_small_screen = '90px';
      $width_large_screen = '150px';

   // Home page
	} elseif ( is_front_page() ) {
		global $entries_count;

      // Set responsive image widths for multi-column display.
      switch( $entries_count ) {
         // 2 columns
         case 2:
            $width_large_screen = '49vw';
            break;
         // 3 columns
         case 3:
            $width_large_screen = '32vw';
            break;
         // 4 columns
         case 4:
            $width_large_screen = '24vw';
            break;
         // Otherwise, bail
         default:
            return;
      }

   // Archive
	} elseif ( is_archive() ) {
      // 3 columns
		$width_large_screen = '32vw';

   // Single
   } elseif ( is_single() ) {
		$breakpoint         = '749px';
      $width_large_screen = '750px';
	}

	$sizes = sprintf(
			'(max-width: %1$s) %2$s, %3$s',
			$breakpoint,
			$width_small_screen,
			$width_large_screen
		);

   return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'base_responsive_image_sizes', 10 , 2 );
