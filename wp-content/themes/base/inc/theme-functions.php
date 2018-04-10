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
 * Limit the number of post revisions stored in the database.
 *
 * Keep zero revisions for the home page to prevent the congestion of ACF flexible fields in wp_postmeta
 *
 * @param integer $num  Number of revisions to keep.
 * @param object  $post WP_Post object of the current post.
 * @return integer Number of revisions to keep.
 */
function base_control_revisions( $num, $post ) {
	// 0 revisions for home page, 5 for all other posts/pages
	$num = ( 'home' == $post->post_name ) ? 0 : 5;
	return $num;
}
add_filter( 'wp_revisions_to_keep', 'base_control_revisions', 10, 2 );

/**
 * Add custom classes to <body> element.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param array $classes Default classes of <body> element.
 * @return array
 */
function base_body_classes( $classes ) {

   /**
    * Whether subscribe form is displayed on this page.
    * @var bool
    */
	$show_subscribe = get_field( 'show_subscribe', 'option' );

	// Add a class of 'hfeed' to non-singular pages
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    // Add a class for page names
	if ( is_page() ) {
      global $post;
		$classes[] = 'page-' . $post->post_name;
	}

   // Add a 'wide-content' class to home page, posts page and archive
   if ( is_front_page() || is_home() || is_archive() ) {
      $classes[] = 'wide-content';
   }

   // Add a page layout class to pages and posts
   if ( is_singular() ) {

      /**
       * CSS class for page layout
       * @var string Possible values are 'one-column', 'wide-content', 'aside-on'.
       */
      $page_layout = get_field( 'page_layout' );

   	if ( $page_layout ) {
   		$classes[] = $page_layout;
   	}

   }

	// Add a class of 'subscribe-on' to pages with subscribe form.
	if ( $show_subscribe ) {
		$classes[] = 'subscribe-on';
	}

	return $classes;
}
add_filter( 'body_class', 'base_body_classes' );

/**
* Add inline CSS to display a background image.
*
* @param string $css_class  CSS class of element being assigned a background image.
* @param string $field_name Field name of background image custom field.
* @param bool   $post_id    Optional. Post id of custom field.
* @return string Inline CSS rules.
*/
function base_get_background_image_css( $css_class, $field_name, $post_id = false ) {

   /**
    * Background image retrieved from custom field, otherwise ACF option page.
    * @var array
    */
	$image = get_field( $field_name, $post_id ) ?: get_field( $field_name, 'option' );

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
 * Add formatting parameters to video embed query string.
 *
 * @link https://www.advancedcustomfields.com/resources/oembed/
 *
 * @param  string $video HTML to display embedded video.
 * @return string        HTML to display embedded video..
 */
function base_format_video( $video ) {

   // Bail if there's no video
   if ( ! $video ) return;

   // Use preg_match to find iframe src
   preg_match( '/src="(.+?)"/', $video, $matches );
   $src = $matches[1];

   // Add extra params to iframe src
   $params = array(
      'showinfo' => 0
   );
   $new_src = add_query_arg( $params, $src );
   $video = str_replace( $src, $new_src, $video );

   // Add extra attributes to iframe html
   $attributes = '';
   $video = str_replace( '></iframe>', ' ' . $attributes . '></iframe>', $video );

   return $video;

}

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
* Add a category icon to the category list.
*
* @uses base_add_string()
* @uses base_inline_svg()
*/
function base_add_category_icon( $category_list ) {
   // If not single, don't add category icon.
   if ( ! is_single() ) return $category_list;

   return base_add_string( $category_list, base_inline_svg( '/icons/folder.svg' ), '<li' );
}
add_filter( 'the_category', 'base_add_category_icon' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function base_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'base_pingback_header' );
