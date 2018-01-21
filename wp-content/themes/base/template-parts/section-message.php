<?php
/**
 * Template part for displaying a brief message section
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

$message_text = get_sub_field( 'message_text' );
$css_class = ( $message_text ) ? '' : ' notext';
?>

<section class="section section-message<?php echo $css_class; ?>">
	<div class="wrap">
		<h2 class="section-title"><?php the_sub_field( 'message_title' ); ?></h2>
		<?php if ( $message_text ) : ?>
			<div class="section-text"><?php echo $message_text; ?></div>
		<?php
		endif;
		$button_css_id = $post->post_name . '-section-message-cta';
		base_button( 'message_button', 'get_sub_field', $button_css_id, '<div class="section-button">', '</div>' );
		?>
	</div><!-- .wrap -->
</section><!-- .section-<?php echo $entries_type; ?> -->
