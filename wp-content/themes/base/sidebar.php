<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Base
 * @since 1.0.1
 */

// Bail if there's no sidebar
if ( ! is_active_sidebar( 'site-aside' ) ) return;
?>

<aside id="site-aside" class="site-aside">
	<?php dynamic_sidebar( 'site-aside' ); ?>
</aside><!-- #site-aside -->
