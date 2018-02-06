<?php
/**
 * The footer for our theme
 *
 * Contains the closing of the <main> tag and all content after.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

// Subscribe form section
get_template_part( 'template-parts/section', 'subscribe' );
?>

	<?php do_action ( 'base_before_footer' ); ?>
	<?php if ( is_active_sidebar( 'footer-left' ) || is_active_sidebar( 'footer-right' ) ) : ?>
		<footer id="site-footer" class="site-footer" role="contentinfo">
			<div class="wrap">
				<section class="footer-left">
					<?php dynamic_sidebar( 'footer-left' ); ?>
				</section>
				<section class="footer-right">
					<?php dynamic_sidebar( 'footer-right' ); ?>
				</section>
			</div>
		</footer><!-- #site-footer -->
	<?php endif; ?>

	<section id="colophon" class="colophon">
		<div class="wrap">
			<div class="branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php base_logo( 'logo_footer' ); ?>
					<h1 class="site-title"><?php base_site_title(); ?></h1>
				</a>
			</div><!-- .branding -->
			<div class="copyright">&copy; 2017 Base Theme</div>
			<?php base_social_links( 'option' ); ?>
		</div><!-- .wrap -->
	</section><!-- #colophon -->

	<?php wp_footer(); ?>

</div><!-- #site -->
</body>
</html>
