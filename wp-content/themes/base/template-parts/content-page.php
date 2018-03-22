<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Base
 * @since 1.0.1
 */
?>

<article <?php post_class(); ?>>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'base' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article>
