<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Base
 * @since 1.0.1
 */

// Bail if there's no sidebar
if ( ! is_active_sidebar( 'site-aside' ) ) return;
?>

<aside id="site-aside" class="site-aside">
	<div class="wrap">
		<?php dynamic_sidebar( 'site-aside' ); ?>
	</div><!-- .wrap -->
</aside><!-- #site-aside -->
