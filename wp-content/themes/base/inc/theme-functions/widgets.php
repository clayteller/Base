<?php
/**
 * Register widgets.
 *
 * @package Base Site
 * @since 1.0.1
 */

/**
 * Include files
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . "widgets/*.php" ) as $file ) {
   require $file;
}

/**
 * Register widgets.
 */
function base_register_widgets()
{
	register_widget( 'Base_Widget_Contact_Info' );
}
add_action( 'widgets_init', 'base_register_widgets' );
