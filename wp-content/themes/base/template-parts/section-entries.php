<?php
/**
 * Template part for displaying a section of entries, which may be 'posts', 'employees', 'services', etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * The 'entries_type' ACF value determines which type of entries we're displaying and if we're displaying the 'latest' entries or a 'custom' set.
 *
 * @var string Possible values are 'posts_latest', 'employees_custom', 'services_custom', etc.
 */
$entries_type_field = get_sub_field( 'entries_type' );

/**
 * Explode the 'entries_type' ACF value into entry type and display type.
 *
 * @var array
 */
$entries_type_parts = explode( '_', $entries_type_field );

/**
 * Type of entries.
 *
 * @var string Possible values are 'posts', 'employees', 'services', etc.
 */
$entries_type = $entries_type_parts[0];

/**
 * Singularize the plural $entries_type, needed for some cases below.
 *
 * @var string
 */
$entries_type_singular = rtrim( $entries_type, 's');

/**
 * Type of display.
 *
 * @var string Possible values are 'latest' or 'custom'
 */
$display_type = $entries_type_parts[1];

/**
 * How many entries are being displayed.
 *
 * @global integer
 * @used-by function base_entry_image_responsive_sizes() to determine how many entries are in a row and what size the entry featured images should be
 */
global $entries_count;

// Custom set of entries retrieved from ACF 'relationship' field
if ( 'custom' == $display_type ) {
	$entries = get_sub_field( 'entries_' . $entries_type );
	$entries_count = count( $entries );
// Latest entries
} elseif ( 'latest' == $display_type )  {
	$entries_count = get_sub_field( 'entries_count' );
	$args = array(
		'posts_per_page' => $entries_count,
		'post_type'      => $entries_type_singular,
	);
	$entries = get_posts( $args );
}
?>

<section class="section section-<?php echo $entries_type; ?>">
	<div class="wrap">
		<h2 class="section-title"><?php the_sub_field( 'section_title' ); ?></h2>
		<?php if ( $entries ): ?>
			<div class="entries count-<?php echo $entries_count; ?>">
				<?php
				foreach ( $entries as $post ): // variable must be called $post (IMPORTANT)
					setup_postdata( $post );
					get_template_part( 'template-parts/entry', $entries_type_singular );
				endforeach;
				wp_reset_postdata();
				?>
			</div>
		<?php endif; ?>
		<?php
		$button_css_id = $post->post_name . '-section-' . $entries_type . '-cta';
		base_button( 'section_button', 'get_sub_field', $button_css_id, '<div class="section-button">', '</div>' );
		?>
	</div><!-- .wrap -->
</section><!-- .section-<?php echo $entries_type; ?> -->