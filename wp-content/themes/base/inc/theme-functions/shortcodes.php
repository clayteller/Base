<?php
/**
 * Register shortcodes for this theme.
 *
 * @package Base Site
 * @since 1.0.1
 */

/**
 * Shortcode to display email address.
 *
 * @uses base_email()
 */
function base_email_shortcode() {
	return base_email( '<span class="email">', '</span>', 'option', false, false );
}
add_shortcode( 'email', 'base_email_shortcode' );

/**
 * Shortcode to display phone number.
 *
 * @uses base_phone()
 */
function base_phone_shortcode() {
	return base_phone( '<span class="phone">', '</span>', 'option', false, false );
}
add_shortcode( 'phone', 'base_phone_shortcode' );


/**
 * Shortcode to list entries.
 *
 * @uses base_inline_svg()
 */
function base_list_entries_shortcode( $atts ) {
	ob_start();

	// Shortcode attributes default values
	$atts_defaults = array(
		 'type' => 'post'
	);

	// Extract shortcode attributes values into variables
	extract( shortcode_atts( $atts_defaults, $atts ) );

	$args = array (
	  'post_type' => sanitize_key( $type ),
	  'orderby'   => 'title',
	  'order'     => 'ASC'
	);

	$query = new WP_Query( $args );

	/**
	 * CSS class for a column layout.
	 *
	 * @var string
	 */
	$css_class = ' columns';

	// 2 columns
	if ( 'benefit' == $args['post_type'] ) {
		$css_class .= ' columns-2';

	// 3 columns
	} elseif ( 'post' == $args['post_type'] || 'employee' == $args['post_type'] ) {
		$css_class .= ' columns-3';

	// None
	} else {
		$css_class = '';
	}

	if ( $query->have_posts() ) :
	?>
		<div class="entries<?php echo $css_class; ?>">
			<?php
			while ( $query->have_posts() ) : $query->the_post();
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

	// Reset post data
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'entries', 'base_list_entries_shortcode' );
