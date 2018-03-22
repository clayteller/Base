<?php
/**
 * Register custom post types.
 *
 * @package Base Site
 * @since 1.0.1
 */

/**
 *  Register custom post types.
 */
function base_register_post_type() {
	/**
	 * Array of custom post types to register.
	 * @var array
	 */
	$post_types = array(
		array(
			'name' => 'benefit',
			'dashicon' => 'awards'
		),
		array(
			'name' => 'employee',
			'dashicon' => 'groups'
		),
		array(
			'name' => 'service',
			'dashicon' => 'store'
		),
		array(
			'name' => 'testimonial',
			'dashicon' => 'format-quote'
		)
	);

	// Loop through each custom post type and register it.
	foreach ( $post_types as $post_type ) {
		$cpt          = $post_type[ 'name' ];
		$cpt_singular = __( ucfirst( $cpt ), 'base' );
		$cpt_plural   = $cpt_singular . 's';

		$labels = array(
			'name'               => $cpt_plural,
			'singular_name'      => $cpt_singular,
			'add_new_item'       => __('Add New ' . $cpt_singular, 'base' ),
			'all_items'          => __('All ' . $cpt_plural, 'base' ),
			'edit_item'          => __('Edit ' . $cpt_singular, 'base' ),
			'new_item'           => __('New ' . $cpt_singular, 'base' ),
			'parent_item_colon'  => '',
			'menu_name'          => $cpt_plural,
		);

		$args = array(
			'has_archive' => true,
			'labels'      => $labels,
			'menu_icon'   => 'dashicons-' . $post_type[ 'dashicon' ],
			'public'      => true,
			'rewrite'     => array( 'slug' => $cpt . 's' ),
			'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		);

		register_post_type( $cpt, $args );
	}
}
add_action( 'init', 'base_register_post_type' );
