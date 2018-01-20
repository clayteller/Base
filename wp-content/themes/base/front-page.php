<?php
/**
 * The template for displaying the home page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Base
 * @since 1.0.1
 */

get_header();
?>

<main id="site-main" class="site-main">

	<?php
	// Loop through ACF 'flexible content'
	if ( have_rows( 'section' ) ):

		while ( have_rows( 'section' ) ): the_row();

			if ( 'entries' == get_row_layout() ):

				get_template_part( 'template-parts/section', 'entries' );

			elseif ( 'partners' == get_row_layout() ):

				get_template_part( 'template-parts/section', 'partners' );

			elseif ( 'message' == get_row_layout() ):

				get_template_part( 'template-parts/section', 'message' );

			endif;

		endwhile;

	endif;
	?>

</main><!-- #site-main -->

<?php
get_footer();
