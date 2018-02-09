<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base
 * @since 1.0.1
 */

get_header();
?>

<main id="site-main" class="site-main">
	<div class="wrap">

		<?php
		if ( have_posts() ) :

			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
			<div class="entries">
				<?php
				while ( have_posts() ) : the_post();
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/entry', get_post_format() );
				endwhile;
				?>
			</div>
			<?php

			the_posts_pagination( array(
				'prev_text' => base_svg_icon( 'chevron' ) . __( 'Previous', 'base' ),
            'next_text' => __( 'Next', 'base' ) . base_svg_icon( 'chevron' )
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div><!-- .wrap -->
</main><!-- #site-main -->

<?php
get_footer();
