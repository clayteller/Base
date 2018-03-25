<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * CSS class for page layout
 *
 * @var string Possible values are '', 'wide-content', 'has-aside'.
 */
$page_layout = get_field( 'page_layout' );

// Bail if there's no sidebar
if ( ! $page_layout = 'has-aside' ) return;

// Get the correct sidebar
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
