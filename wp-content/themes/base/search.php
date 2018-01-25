<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/entry', 'search' );

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
