<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
if ( base_has_sidebar() ) {
	get_sidebar();
}
get_footer();
