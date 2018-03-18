<?php
/**
* Add theme settings (ACF options pages) to the WordPress admin
 *
 * @package Base Admin
 * @since 1.0.1
 */

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' 	=> 'Base Theme Settings',
		'menu_title'	=> 'Base Theme',
		'menu_slug' 	=> 'base-theme-settings',
		'capability'	=> 'edit_pages',
		'position'	   => 3,
		'icon_url'     => 'dashicons-admin-site'
	));

	acf_add_options_sub_page( array(
		'page_title' 	=> 'Site Header',
		'menu_title'	=> 'Site Header',
		'parent_slug'	=> 'base-theme-settings'
	));

	acf_add_options_sub_page( array(
		'page_title' 	=> 'Site Footer',
		'menu_title'	=> 'Site Footer',
		'parent_slug'	=> 'base-theme-settings',
	));

	acf_add_options_sub_page( array(
		'page_title' 	=> 'Company Contact',
		'menu_title'	=> 'Company Contact',
		'parent_slug'	=> 'base-theme-settings',
	));

	acf_add_options_sub_page( array(
		'page_title' 	=> 'Subscribe Form',
		'menu_title'	=> 'Subscribe Form',
		'parent_slug'	=> 'base-theme-settings',
	));

	acf_add_options_sub_page( array(
		'page_title' 	=> 'Partner Logos',
		'menu_title'	=> 'Partner Logos',
		'parent_slug'	=> 'base-theme-settings',
	));

}
