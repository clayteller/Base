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
				// Entries section – possible types are 'employees', 'services', 'testimonials' and 'posts'
				case 'entries':
					get_template_part( 'template-parts/section', 'entries' );
			   	break;
				// Message section
				case 'message':
					get_template_part( 'template-parts/section', 'message' );
			   	break;
				// Partner logos section
				case 'partners':
					get_template_part( 'template-parts/section', 'partners' );
			   	break;
				// Subscribe form section
				case 'subscribe':
					get_template_part( 'template-parts/section', 'subscribe' );
			   	break;
			}

		endwhile;

	endif;
	?>

</main><!-- #site-main -->

<?php
get_footer();
