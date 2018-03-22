<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * CSS class for a column layout.
 *
 * @var string
 */
$css_class = ' columns';

// 2 columns
if ( 'benefit' == get_post_type() ) {
	$css_class .= ' columns-2';

// 3 columns
} elseif ( 'post' == get_post_type() || 'employee' == get_post_type() ) {
	$css_class .= ' columns-3';

// None
} else {
	$css_class = '';
}

get_header();
?>

<main id="site-main" class="site-main">
	<div class="wrap">

		<?php
		if ( have_posts() ) :

			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
			<div class="entries<?php echo $css_class; ?>">
				<?php
				while ( have_posts() ) : the_post();
					// Include the post-format-specific template for the content. If you want to override this in a child theme, then include a file called entry-___.php (where ___ is the Post Format name) and that will be used instead.
					get_template_part( 'template-parts/entry', get_post_format() );
				endwhile;
				?>
			</div>
			<?php

			the_posts_pagination( array(
				'prev_text' => base_inline_svg( '/icons/chevron.svg' ) . __( 'Previous', 'base' ),
            'next_text' => __( 'Next', 'base' ) . base_inline_svg( '/icons/chevron.svg' )
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div><!-- .wrap -->
</main><!-- #site-main -->

<?php
get_footer();
