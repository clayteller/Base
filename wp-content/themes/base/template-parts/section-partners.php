<?php
/**
 * Template part for displaying a partner logos section
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

$images = get_field( 'partner_logos_images', 'option' );

// Bail if there's no logo images
if ( ! $images ) return;

$title = get_field( 'partner_logos_title', 'option' );
$size = 'full';
?>

<section class="section section-partners">
	<div class="wrap">

		<?php if ( $title ) : ?>
			<h2 class="section-title"><?php echo $title; ?></h2>
		<?php endif; ?>

		<div class="logos">
			<?php
			foreach( $images as $image ):
				echo wp_get_attachment_image( $image['ID'], $size );
			endforeach;
			?>
		</div>

	</div><!-- .wrap -->
</section><!-- .section-partners -->
