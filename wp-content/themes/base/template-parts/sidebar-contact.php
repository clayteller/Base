<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Base
 * @since 1.0.1
 */

if ( ! is_active_sidebar( 'site-aside' ) ) {
	return;
}
?>

<aside id="site-aside" class="site-aside">
	<?php dynamic_sidebar( 'site-aside' ); ?>
</aside><!-- #site-aside -->
