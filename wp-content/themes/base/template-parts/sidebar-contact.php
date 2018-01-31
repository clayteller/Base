<?php
/**
 * The 'Contact' page sidebar
 *
 * @package Base
 * @since 1.0.1
 */
?>

<aside id="site-aside" class="site-aside">
	<div class="wrap">
		<div class="contact-info">
	   	<?php
	      base_phone( '<p class="phone">', '</p>', 'option' );
			base_email( '<p class="email">', '</p>', 'option' );
			base_address();
			?>
		</div>
		<?php get_template_part( 'template-parts/map' ); ?>
   </div><!-- .wrap -->
</aside><!-- #site-aside -->
