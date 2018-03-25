<?php
/**
 * Base functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Theme directory URL.
 * @var string
 */
define( 'THEME_URL', get_stylesheet_directory_uri() );

/**
 * Theme directory file path.
 * @var string
 */define( 'THEME_PATH', get_stylesheet_directory() );

if ( ! function_exists( 'base_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function base_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Base, use a find and replace
		 * to change 'base' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'base', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

      // Add image sizes for people photos
		add_image_size( 'square', 300, 300, true );
		add_image_size( 'square@2x', 600, 600, true );

      // Add image sizes for featured images
		add_image_size( 'featured', 600, 330, true );
		add_image_size( 'featured@2x', 1200, 660, true );

		// This theme uses wp_nav_menu().
		register_nav_menus( array(
			'menu-site'   => esc_html__( 'Masthead', 'base' ),
			'menu-footer' => esc_html__( 'Footer', 'base' )
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
	}
endif;
add_action( 'after_setup_theme', 'base_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function base_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'base_content_width', 1200 );
}
add_action( 'after_setup_theme', 'base_content_width', 0 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function base_register_sidebar() {
	/**
	 * Array of widget areas to register.
	 * @var array
	 */
	$sidebars = array(
		array(
			'name'        => 'Sidebar',
			'id'          => 'sidebar',
			'description' => 'This sidebar is displayed on pages and posts. It\'s not displayed on Home, Blog or Contact page.'
		),
		array(
			'name'        => 'Sidebar – Contact',
			'id'          => 'sidebar-contact',
			'description' => 'This sidebar is displayed on the Contact page.'
		),
		array(
			'name'        => 'Footer – Left',
			'id'          => 'footer-left',
			'description' => 'This sidebar is displayed on the left side of the site footer.'
		),
		array(
			'name'        => 'Footer – Right',
			'id'          => 'footer-right',
			'description' => 'This sidebar is displayed on the right side of the site footer.'
		)
	);

	// Loop through each widget area and register it.
	foreach ( $sidebars as $sidebar ) {
		register_sidebar( array(
			'name'          => esc_html__( $sidebar['name'], 'base' ),
			'id'            => $sidebar['id'],
			'description'   => esc_html__( $sidebar['description'], 'base' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'base_register_sidebar' );

/**
 * Load Typekit fonts
 */
function base_typekit() {
   ?>
   <link rel="stylesheet" href="https://use.typekit.net/ghn1efv.css">
   <?php
}
add_action('wp_head', 'base_typekit');


/**
 * Enqueue scripts and styles.
 */
function base_scripts() {
   // normalize.css
	$file = base_get_min_file( '/css/normalize.min.css' );
	wp_enqueue_style( 'base-normalize-css', THEME_URL . $file );

	// style.css
	$file = base_get_min_file( '/style.min.css' );
	wp_enqueue_style( 'base-style', THEME_URL . $file, array( 'base-normalize-css' ) );

   // Add inline css to display the "Header Background Image" (custom field)
   $header_background_image_css = base_get_background_image_css( 'site-header', 'header_background_image' );
   wp_add_inline_style( 'base-style', $header_background_image_css );

   // Add inline css to display the "Footer Background Image" (custom field)
   $footer_background_image_css = base_get_background_image_css( 'site-footer', 'footer_background_image', 'option' );
   wp_add_inline_style( 'base-style', $footer_background_image_css );

   // Add inline css to display each "Social Icon" (custom field)
   // $social_icons_css = base_get_icon_css( 'social_links', 'option' );
   // wp_add_inline_style( 'base-style', $background_image_css );

   // main.js
	$file = base_get_min_file( '/js/main.min.js' );
	wp_enqueue_script( 'base-main', THEME_URL . $file, array( 'jquery', 'base-gsap' ), false, true );

	// lightbox.js (load on single post pages)
	if ( is_singular()  ) {
		// lightbox.js
		$file = base_get_min_file( '/js/lightbox.min.js' );
		wp_enqueue_script( 'base-lightbox', THEME_URL . $file, array( 'jquery', 'base-featherlight', 'base-featherlight-gallery' ), false, true );

		// Pass svg icon html to lightbox.js
		wp_localize_script( 'base-lightbox', 'baseTheme', array(
			'iconChevron'    => base_inline_svg( '/icons/chevron.svg' ),
			'loadingGraphic' => base_inline_svg( '/images/loading.svg' )
		) );

		// Featherlight css
		$file = base_get_min_file( '/css/featherlight.min.css' );
		wp_enqueue_style( 'base-featherlight-style', THEME_URL . $file );
		// Featherlight gallery css
		$file = base_get_min_file( '/css/featherlight.gallery.min.css' );
		wp_enqueue_style( 'base-featherlight-gallery-style', THEME_URL . $file );

		// Featherlight js
		$file = base_get_min_file( '/js/lib/featherlight.min.js' );
		wp_enqueue_script( 'base-featherlight', THEME_URL . $file, array( 'base-swipe' ), false, true );
		// Featherlight gallery js
		$file = base_get_min_file( '/js/lib/featherlight.gallery.min.js' );
		wp_enqueue_script( 'base-featherlight-gallery', THEME_URL . $file, array( 'base-swipe' ), false, true );

		// jQuery swipe
		$file = base_get_min_file( '/js/lib/jquery.detect_swipe.min.js' );
		wp_enqueue_script( 'base-swipe', THEME_URL . $file, array( 'jquery' ), '20151215', true );
	}

	// GSAP js
	wp_enqueue_script( 'base-gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js', array(  ), false, true );

	// Comment reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'base_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Helper functions for this theme.
 */
require get_template_directory() . '/inc/helpers.php';
