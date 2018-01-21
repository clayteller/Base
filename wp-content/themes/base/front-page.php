<?php
/**
 * The template for displaying the home page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

get_header();
?>

<main id="site-main" class="site-main">

	<?php
	// Loop through 'flexible content' custom field
	if ( have_rows( 'section' ) ):

		while ( have_rows( 'section' ) ): the_row();

			switch( get_row_layout() ) {
				case 'entries':
					get_template_part( 'template-parts/section', 'entries' );
			   	break;
				case 'partners':
					get_template_part( 'template-parts/section', 'partners' );
			   	break;
				case 'message':
					get_template_part( 'template-parts/section', 'message' );
			   	break;
			}

		endwhile;

	endif;
	?>

</main><!-- #site-main -->

<?php
get_footer();
