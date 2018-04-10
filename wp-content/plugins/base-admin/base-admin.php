<?php
/*
Plugin Name: Base Admin
Description: Custom functionality only for Wordpress admin.
Version: 0.1
Author: Clay Teller
Author URI: http://clayteller.com
Text Domain: base
Domain Path: /languages
License: GPL2
*/

// Abort if accessed outside WordPress
defined( 'WPINC' ) or die();

/**
 * Include files
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . "inc/*.php" ) as $file ) {
	require $file;
}

/**
 * Enqueue scripts and styles.
 */
function base_admin_scripts() {
	wp_register_style( 'base_admin_stylesheet', plugins_url( '/css/admin.css', __FILE__ ) );
	wp_enqueue_style( 'base_admin_stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'base_admin_scripts' );

/**
 * Admin styles for TinyMCE
 */
function base_mce_css($wp) {
	$wp .= ',' . plugins_url( '/css/admin.css', __FILE__ );
	return $wp;
}
add_filter( 'mce_css', 'base_mce_css' );

/**
 * Hide WordPress update notification from non-adin users.
 */
function base_hide_update_notice_from_non_admins() {
	if ( ! current_user_can( 'update_core' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
	}
}
add_action( 'admin_head', 'base_hide_update_notice_from_non_admins', 1 );

/**
 * Dashboard setup for non-administrators
 */
function base_remove_dashboard_widgets() {
	$user = wp_get_current_user();
	if ( ! current_user_can( 'manage_options' ) ) {
		// Quick Press
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
		// WordPress Blog
		remove_meta_box('dashboard_primary', 'dashboard', 'side');
		// Other WordPress News
		remove_meta_box('dashboard_secondary', 'dashboard', 'side');
	}
}
add_action( 'wp_dashboard_setup', 'base_remove_dashboard_widgets' );

/**
 * Pages table columns
 */
function base_pages_columns( $columns ) {
	unset( $columns[ 'comments' ] );
	return $columns;
}
add_action( 'manage_pages_columns', 'base_pages_columns' );

/**
 * Posts table columns
 */
function base_posts_columns( $columns ) {
	unset( $columns[ 'tags' ] );
	return $columns;
}
add_action( 'manage_posts_columns', 'base_posts_columns' );

/**
 * Widgets
 */
function base_remove_widgets() {
	unregister_widget('WP_Widget_Pages');
	// unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	// unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Meta');
	// unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	// unregister_widget('WP_Nav_Menu_Widget');
}
add_action('widgets_init', 'base_remove_widgets', 11);

/**
 * TinyMCE text editor
 */
function base_custom_tinymce( $init ) {
	// CSS formatting options
	$init['theme_advanced_blockformats'] = 'h2,h3,h4,p';
	// Remove buttons
	$init['theme_advanced_disable'] = 'underline,justifyfull,forecolor,wp_help';
	return $init;
}
add_filter('tiny_mce_before_init', 'base_custom_tinymce');

/**
 * Media attachment defaults
 */
function base_default_attachment() {
	update_option( 'image_default_link_type', 'none' );
}
add_action( 'after_setup_theme', 'base_default_attachment' );

/**
 * Add the content editor to the posts page edit screen.
 *
 * @param Object $post
 * @return void
 */
function base_add_editor_to_posts_page( $post ) {
   // Bail if not posts page
   if ( isset( $post ) && $post->ID != get_option('page_for_posts') ) return;

   remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
   add_post_type_support( 'page', 'editor' );
}
add_action( 'edit_form_after_title', 'base_add_editor_to_posts_page', 0 );

/**
 * Move Yoast SEO meta box to bottom of page
 */
function base_move_yoast_meta_down() {
    return 'low';
}
add_filter( 'wpseo_metabox_prio', 'base_move_yoast_meta_down' );

/**
 * For extra security, disable the Appearance > Editor section in WordPress admin
 * @var bool
 */
define( 'DISALLOW_FILE_EDIT', true );
