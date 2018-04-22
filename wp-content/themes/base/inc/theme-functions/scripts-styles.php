<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Enqueue scripts and styles.
 */
function base_scripts() {
   // normalize.css
	$file = base_get_min_file( '/css/normalize.min.css' );
	wp_enqueue_style( 'base-normalize-css', THEME_URL . $file );

	// style.css
	$file = base_get_min_file( '/style.min.css' );
	wp_enqueue_style( 'base-style', THEME_URL . $file, array( 'base-normalize-css' ) );

   // Add inline css to display the "Header Background Image" (custom field)
   $header_background_image_css = base_get_background_image_css( 'site-header', 'header_background_image' );
   wp_add_inline_style( 'base-style', $header_background_image_css );

   // Add inline css to display the "Footer Background Image" (custom field)
   $footer_background_image_css = base_get_background_image_css( 'site-footer', 'footer_background_image', 'option' );
   wp_add_inline_style( 'base-style', $footer_background_image_css );

   // Add inline css to display each "Social Icon" (custom field)
   // $social_icons_css = base_get_icon_css( 'social_links', 'option' );
   // wp_add_inline_style( 'base-style', $background_image_css );

   // main.js
	$file = base_get_min_file( '/js/main.min.js' );
	wp_enqueue_script( 'base-main', THEME_URL . $file, array( 'jquery', 'base-gsap' ), false, true );

	// lightbox.js (load on single post pages)
	if ( is_singular()  ) {
		// lightbox.js
		$file = base_get_min_file( '/js/lightbox.min.js' );
		wp_enqueue_script( 'base-lightbox', THEME_URL . $file, array( 'jquery', 'base-featherlight', 'base-featherlight-gallery' ), false, true );

		// Pass svg icon html to lightbox.js
		wp_localize_script( 'base-lightbox', 'baseTheme', array(
			'iconChevron'    => base_inline_svg( '/icons/chevron.svg' ),
			'loadingGraphic' => base_inline_svg( '/images/loading.svg' )
		) );

		// Featherlight css
		$file = base_get_min_file( '/css/featherlight.min.css' );
		wp_enqueue_style( 'base-featherlight-style', THEME_URL . $file );
		// Featherlight gallery css
		$file = base_get_min_file( '/css/featherlight.gallery.min.css' );
		wp_enqueue_style( 'base-featherlight-gallery-style', THEME_URL . $file );

		// Featherlight js
		$file = base_get_min_file( '/js/lib/featherlight.min.js' );
		wp_enqueue_script( 'base-featherlight', THEME_URL . $file, array( 'base-swipe' ), false, true );
		// Featherlight gallery js
		$file = base_get_min_file( '/js/lib/featherlight.gallery.min.js' );
		wp_enqueue_script( 'base-featherlight-gallery', THEME_URL . $file, array( 'base-swipe' ), false, true );

		// jQuery swipe
		$file = base_get_min_file( '/js/lib/jquery.detect_swipe.min.js' );
		wp_enqueue_script( 'base-swipe', THEME_URL . $file, array( 'jquery' ), '20151215', true );
	}

	// GSAP js
	wp_enqueue_script( 'base-gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js', array(  ), false, true );

	// Comment reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'base_scripts' );
