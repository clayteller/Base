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
 * Filter which entries are displayed.
 *
 * @var string Possible values are 'latest' or 'custom'
 */
$filter = get_sub_field( 'filter' );

/**
 * How many entries are being displayed.
 *
 * @global integer
 * @used-by function base_entry_image_responsive_sizes() to determine how many entries are in a row and what size the entry featured images should be
 */
global $entries_count;

// Custom set of entries retrieved from 'relationship' custom field.
if ( 'custom' == $filter ) {
	$entries = get_sub_field( 'entries_' . $entries_type );
	$entries_count = count( $entries );
// Latest entries
} else  {
	$entries_count = get_sub_field( 'entries_count' ) ?: '3';
	$args = array(
		'posts_per_page' => $entries_count,
		'post_type'      => $entry_type,
	);
	$entries = get_posts( $args );
}

/**
 * Section subtitle.
 *
 * @var string
 */
$subtitle = get_sub_field( 'section_subtitle' );

/**
 * CSS class to determine layout of entries.
 *
 * @var string
 */
$css_class = ' columns';

// 2 columns
if ( 'benefits' == $entries_type ) {
	$css_class .= ' columns-2';

// None
} elseif ( 'services' == $entries_type || 'testimonials' == $entries_type ) {
	$css_class = '';

// Columns depend on count
} else {
	$css_class .= ' columns-' . $entries_count;
}
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
			<div class="entries<?php echo $css_class; ?>">
				<?php
				$i = 0;
				foreach ( $entries as $post ): // variable must be called $post (IMPORTANT)
					$i++;
					setup_postdata( $post );
					// Include the post-format-specific template for the content. If you want to override this in a child theme, then include a file called entry-___.php (where ___ is the Post Format name) and that will be used instead.
					get_template_part( 'template-parts/entry', get_post_format() );
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
