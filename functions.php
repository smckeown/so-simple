<?php
/**
 * So Simple functions and definitions.
 *
 * @package So Simple
 */


/**
 * Create "non-cachable" version ID.
 * Helpful for caching issues in development.
 */
define( 'THEME_VERSION', '2.0.0' );

function sosimple_version_id() {
	if ( WP_DEBUG )
		return time();
	return THEME_VERSION;
}


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 860;
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sosimple_setup() {
	// Add support for translating strings in this theme.
	load_theme_textdomain( 'so-simple-i18n', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add support for post thumbnails and register custom image sizes.
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'sosimple_setup' );


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function sosimple_fonts_url() {
	$fonts_url = '';

	/* translators: If there are characters in your language that are not supported
	   by Lustria, translate this to 'off'. Do not translate into your own language. */
	$lustria = _x( 'on', 'Lustria font: on or off', 'so-simple-i18n' );

	if ( 'off' !== $lustria ) {
		$query_args = array(
			'family' => 'Lustria',
		);

		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/**
 * Enqueue scripts and styles.
 */
function sosimple_scripts_styles() {
	wp_enqueue_style( 'so-simple-fonts', sosimple_fonts_url(), array(), null );
	wp_enqueue_style( 'so-simple-style', get_stylesheet_uri(), array(), sosimple_version_id() );

	wp_enqueue_script( 'so-simple-script', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), sosimple_version_id(), true );
}
add_action( 'wp_enqueue_scripts', 'sosimple_scripts_styles' );


/**
 * Output elements in the document head.
 */
function sosimple_document_head() {
	echo '<link rel="profile" href="http://gmpg.org/xfn/11">' . "\n";
	echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";

	echo '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . "\n";
	echo '<script>document.documentElement.className = document.documentElement.className.replace(\'no-js\',\'js\');</script>' . "\n";
}
add_action( 'wp_head', 'sosimple_document_head' );


/**
 * Load additional files and functions.
 */
require( get_template_directory() . '/includes/template-tags.php' );
require( get_template_directory() . '/includes/extras.php' );
require( get_template_directory() . '/includes/customizer.php' );

if ( is_admin() ) {
	require( get_template_directory() . '/includes/admin/admin.php' );
}