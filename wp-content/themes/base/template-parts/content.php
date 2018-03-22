<?php
/**
 * Template part for displaying a post on a single page
 *
 * @package Base
 * @since 1.0.1
 */

$image = get_the_post_thumbnail( null, 'featured' );
?>

<article <?php post_class(); ?>>
	<?php
	if ( $image ) :
	?>
		<figure class="entry-image"><?php echo $image; ?></figure>
	<?php
	endif;
	if ( 'post' === get_post_type() ) :
	?>
		<header class="entry-header">
			<p class="entry-meta"><?php base_entry_meta(); ?></p>
		</header><!-- .entry-header -->
	<?php
	endif;
	?>

	<div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'base' ),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'base' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
	<?php if ( 'post' === get_post_type() ) : ?>
		<footer class="entry-footer">
			<?php
			base_entry_categories();
			base_entry_tags();
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article>
