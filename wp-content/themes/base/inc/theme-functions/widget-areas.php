<?php
/**
 * Register widget areas.
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function base_register_sidebar() {
	/**
	 * Array of widget areas to register.
	 * @var array
	 */
	$sidebars = array(
		array(
			'name'        => 'Sidebar',
			'id'          => 'sidebar',
			'description' => 'This sidebar is displayed on pages and posts. It\'s not displayed on Home, Blog or Contact page.'
		),
		array(
			'name'        => 'Sidebar – Contact',
			'id'          => 'sidebar-contact',
			'description' => 'This sidebar is displayed on the Contact page.'
		),
		array(
			'name'        => 'Footer – Left',
			'id'          => 'footer-left',
			'description' => 'This sidebar is displayed on the left side of the site footer.'
		),
		array(
			'name'        => 'Footer – Right',
			'id'          => 'footer-right',
			'description' => 'This sidebar is displayed on the right side of the site footer.'
		)
	);

	// Loop through each widget area and register it.
	foreach ( $sidebars as $sidebar ) {
		register_sidebar( array(
			'name'          => esc_html__( $sidebar['name'], 'base' ),
			'id'            => $sidebar['id'],
			'description'   => esc_html__( $sidebar['description'], 'base' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'base_register_sidebar' );
