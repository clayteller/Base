<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Base
 * @since 1.0.1
 */
?>

<div class="entry-content">
	<?php	if ( is_search() ) : ?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'base' ); ?></p>
		<?php get_search_form(); ?>

	<?php else : ?>

		<p><?php esc_html_e( 'Sorry, we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'base' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>
</div><!-- .entry-content -->
