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
 */
define( 'THEME_PATH', get_stylesheet_directory() );

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
		 */
		load_theme_textdomain( 'base', THEME_PATH . '/languages' );

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
			'primary' => esc_html__( 'Masthead', 'base' ),
			'footer'  => esc_html__( 'Footer', 'base' )
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
 * This value controls the max width of media elements like oEmbeds. Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function base_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'base_content_width', 1200 );
}
add_action( 'after_setup_theme', 'base_content_width', 0 );

/**
 * Custom template tags for this theme.
 */
require THEME_PATH . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require THEME_PATH . '/inc/theme-functions.php';

/**
 * Customizer additions.
 */
require THEME_PATH . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require THEME_PATH . '/inc/jetpack.php';
}

/**
 * Helper functions for this theme.
 */
require THEME_PATH . '/inc/helpers.php';
