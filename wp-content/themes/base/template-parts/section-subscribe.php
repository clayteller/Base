<?php
/**
 * Template part for displaying a subscribe form
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

$show_subscribe = get_field( 'show_subscribe', 'option' );
$title = get_field( 'section_title', 'option' );
$text = get_field( 'section_text', 'option' );

// Bail if 'Show Subscribe Form?' is 'No'
if ( ! $show_subscribe ) return;
?>

<section class="section section-cta section-subscribe">
	<div class="wrap">

		<?php if ( $title ) : ?>
			<h2 class="section-title"><?php echo $title; ?></h2>
		<?php endif; ?>

		<?php if ( $text ) : ?>
			<div class="section-text"><?php echo $text; ?></div>
		<?php endif; ?>

		<?php echo do_shortcode( '[contact-form-7 id="134" title="Subscribe"]' ); ?>

	</div><!-- .wrap -->
</section><!-- .section-subscribe -->
