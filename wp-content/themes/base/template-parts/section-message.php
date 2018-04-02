<?php
/**
 * Template part for displaying a brief message section
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

$subtitle = get_sub_field( 'message_subtitle' );
$content = get_sub_field( 'message_content' );
$video = get_sub_field( 'message_video' ) ? '<div class="video">' . base_format_video( get_sub_field( 'message_video' ) ) . '</div>' : null;
$background_color = get_sub_field( 'message_background_color' );
$css_class = '';

switch ( $background_color ) {
	case 'light':
		$css_class .= ' section-light';
		break;
	case 'primary':
		$css_class .= ' section-feature';
		break;
	case 'secondary':
		$css_class .= ' section-feature-2';
		break;
}

$css_class .= ( $content || $video ) ? '' : ' section-slim';
?>

<section class="section section-message<?php echo $css_class; ?>">
	<div class="wrap">
		<h2 class="section-title"><?php the_sub_field( 'message_title' ); ?></h2>
		<?php
		if ( $content || $video ) :
		?>
			<div class="section-content">
				<?php
				echo $content;
				echo $video;
				?>
			</div>
		<?php
		endif;
		$gtm_id = $post->post_name . '-message-cta';
		base_button( 'message_button', 'get_sub_field', $gtm_id, '<div class="section-button">', '</div>' );
		?>
	</div><!-- .wrap -->
</section><!-- .section-message -->
