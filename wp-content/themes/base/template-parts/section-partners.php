<?php
/**
 * Template part for displaying a section of partner logos
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Base
 * @since 1.0.1
 */

$title = get_sub_field( 'section_title' );
$images = get_sub_field( 'logos' );
$size = 'full';

if( $images ):
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
	</section><!-- .section-<?php echo $entries_type; ?> -->

<?php
endif;
