<?php
/**
 * The header for our theme
 *
 * Displays the <head> section and everything up until <main>
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Base
 * @since 1.0.1
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="site" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'base' ); ?></a>

	<section id="masthead" class="masthead" role="banner">
		<div class="wrap">
			<div class="branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php base_logo(); ?>
					<h1 class="site-title"><?php base_site_title(); ?></h1>
				</a>
			</div><!-- .branding -->

			<nav id="site-nav" class="site-nav">
				<button class="menu-toggle" aria-controls="site-menu" aria-expanded="false">
					<?php require THEME_PATH . '/icons/menu.svg'; ?>
					<span><?php esc_html_e( 'Menu', 'base' ); ?></span>
				</button>
				<?php
				wp_nav_menu( array(
					'container'      => '',
					'menu_class'     => 'site-menu',
					'menu_id'        => 'site-menu',
					'theme_location' => 'menu-site',
				) );
				?>
			</nav><!-- #site-nav -->
		</div><!-- .wrap -->
	</section><!-- #masthead -->

	<header id="site-header" class="site-header">
		<div class="wrap">
			<?php base_page_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php
			// Display a call to action button on the home page
			if ( is_front_page() ) :
				base_button( 'cta', 'get_field', $post->post_name . '-header-cta', '<div>', '</div>' );
			endif;
			?>
		</div><!-- .wrap -->
	</header><!-- #site-header -->
