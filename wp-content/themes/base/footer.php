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

$footer_summary = get_field( 'site_summary', 'option' ) ? get_field( 'site_summary', 'option' ) : get_bloginfo( 'description' );

// Subscribe form section
get_template_part( 'template-parts/section', 'subscribe' );
?>

	<footer id="site-footer" class="site-footer" role="contentinfo">
		<div class="wrap">
			<div class="footer-summary">
				<p><?php echo $footer_summary; ?></p>
				<p><?php the_field( 'phone', 'option' ); ?></p>
			</div>
			<nav id="footer-nav" class="footer-nav">
				<?php
					wp_nav_menu( array(
						'container'      => '',
						'menu_class'     => 'footer-menu',
						'theme_location' => 'menu-footer'
					) );
				?>
			</nav><!-- #footer-nav -->
		</div>
	</footer><!-- #site-footer -->

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
