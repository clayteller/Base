<?php
/*
Plugin Name: Base Site
Description: Custom functionality for this site.
Version: 0.1
License: GPL
Author: Clay Teller
Author URI: http://clayteller.com
*/

// Abort if accessed outside WordPress
defined( 'ABSPATH' ) or die();

/**
* Include files
*/
foreach ( glob( plugin_dir_path( __FILE__ ) . "inc/*.php" ) as $file ) {
	require $file;
}

/**
 *  Edit link remove
 */
add_filter( 'edit_post_link', '__return_false' );

/**
 * Don't automatically wrap images in paragraph tags
 */
function base_filter_ptags_on_images( $content ){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'base_filter_ptags_on_images');

/**
 * Remove unnecessary classes from post
 */
function base_cleanup_post_classes( $classes ) {
	global $post;

	$exclude = array(
		'has-post-thumbnail',
		$post->post_type,
		'post-' . $post->ID,
		'status-' . $post->post_status
	);

	return array_diff( $classes, $exclude );
}
add_filter( 'post_class', 'base_cleanup_post_classes' );

/**
 * Strip the prefix off Archive page titles
 */
function base_cleanup_archive_title( $title ) {
   return preg_replace('/^\w+: /', '', $title);
}
add_filter( 'get_the_archive_title', 'base_cleanup_archive_title' );

/**
 * Don't paginate custom post types archives
 */
function base_cpt_posts_per_page( $query ) {
  if ( $query->is_main_query() && is_post_type_archive() ) {
    $query->set( 'posts_per_page', '-1' );
  }
}
add_action( 'pre_get_posts', 'base_cpt_posts_per_page' );

/**
 * Remove 'hentry' css class from pages
 *
 * @todo Prevent 'hentry' being removed from entries listed on a page
 */
function base_remove_hentry( $classes ) {
    if ( is_page() ) {
        $classes = array_diff( $classes, array( 'hentry' ) );
    }
    return $classes;
}
// add_filter( 'post_class', 'base_remove_hentry' );
