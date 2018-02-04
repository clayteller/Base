<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Base
 * @since 1.0.1
 */

if ( is_page( 'contact' ) ) {
	$id = 'sidebar-contact';
} else {
	$id = 'sidebar';
}

// Bail if not showing sidebar
if ( ! base_show_sidebar() ) return;
?>

<aside id="site-aside" class="site-aside">
	<div class="wrap">
		<?php dynamic_sidebar( $id ); ?>
	</div><!-- .wrap -->
</aside><!-- #site-aside -->
