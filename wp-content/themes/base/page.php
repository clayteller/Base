<?php
/**
 * The template for displaying all pages
 *
 * @uses base_body_classes() in template-functions.php
 *
 * @package Base
 * @since 1.0.1
 */

get_header();
?>

<main id="site-main" class="site-main">
	<div class="wrap">
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', 'page' );
		endwhile;
		?>
	</div><!-- .wrap -->
</main><!-- #site-main -->

<?php
get_sidebar();
get_footer();
