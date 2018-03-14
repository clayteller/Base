<?php
/**
 * Template part for displaying an entries (posts) section.
 *
 * Post types include 'post', 'employee', 'service' and 'testimonial'.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Type of entries (type of posts)
 *
 * @var string Possible values are 'posts', 'employees', 'services', etc.
 */
$entries_type = get_sub_field( 'entries_type' );

/**
 * Singularize the plural $entries_type, needed for some cases below.
 *
 * @var string
 */
$entry_type = rtrim( $entries_type, 's');

/**
 * Type of display.
 *
 * @var string Possible values are 'latest' or 'custom'
 */
$display_type = get_sub_field( 'display_type' );

/**
 * How many entries are being displayed.
 *
 * @global integer
 * @used-by function base_entry_image_responsive_sizes() to determine how many entries are in a row and what size the entry featured images should be
 */
global $entries_count;

// Custom set of entries retrieved from 'relationship' custom field.
if ( 'custom' == $display_type ) {
	$entries = get_sub_field( 'entries_' . $entries_type );
	$entries_count = count( $entries );
// Latest entries
} elseif ( 'latest' == $display_type )  {
	$entries_count = get_sub_field( 'entries_count' );
	$args = array(
		'posts_per_page' => $entries_count,
		'post_type'      => $entry_type,
	);
	$entries = get_posts( $args );
}

$subtitle = get_sub_field( 'section_subtitle' );
?>

<section class="section section-<?php echo $entries_type; ?>">
	<div class="wrap">
		<header class="section-header">
			<h2 class="section-title"><?php the_sub_field( 'section_title' ); ?></h2>
			<?php if ( $subtitle ) : ?>
				<p class="subtitle"><?php echo $subtitle; ?></p>
			<?php endif; ?>
		</header>
		<?php if ( $entries ) : ?>
			<div class="entries count-<?php echo $entries_count; ?>">
				<?php
				foreach ( $entries as $post ): // variable must be called $post (IMPORTANT)
					setup_postdata( $post );
					// Not using get_template_part here because we need to access variables from this file in the template part.
					include( locate_template( 'template-parts/entry.php' ) );
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
