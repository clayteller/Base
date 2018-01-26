<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Fix the issue of 'blog' page using this template instead of the archive template.
 *
 * @todo Figure out why 'blog' page doesn't use archive template.
 */
if ( base_is_blog() ) {
	load_template( get_archive_template() );
	return;
}

get_header();
?>

<main id="site-main" class="site-main">
	<div class="wrap">

		<?php
		if ( have_posts() ) :


			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div><!-- .wrap -->
</main><!-- #site-main -->

<?php
get_footer();
