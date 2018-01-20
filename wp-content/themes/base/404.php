<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Base
 * @since 1.0.1
 */

get_header();
?>

<main id="site-main" class="site-main">
	<div class="wrap">

		<h2><?php _e( 'Sorry, that page couldn&rsquo;t be found.', 'base' ); ?></h2>
		<p><?php _e( 'Perhaps it&rsquo;s been retired or moved. Maybe try searching below?', 'base' ); ?></p>

		<?php	get_search_form(); ?>

	</div><!-- .wrap -->
</main><!-- #site-main -->

<?php
get_footer();
