<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Base
 * @since 1.0.1
 */
 
 // Bail if not showing sidebar
 if ( ! base_show_sidebar() ) return;

if ( is_page( 'contact' ) ) {
	$id = 'sidebar-contact';
} else {
	$id = 'sidebar';
}
?>

<aside id="site-aside" class="site-aside">
	<div class="wrap">
		<?php dynamic_sidebar( $id ); ?>
	</div><!-- .wrap -->
</aside><!-- #site-aside -->
