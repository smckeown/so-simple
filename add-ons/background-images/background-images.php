<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sosimple_setup_background_images() {
	// Add support for post thumbnails and register custom image sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1024, 768, true );
}
add_action( 'after_setup_theme', 'sosimple_setup_background_images' );


/**
 * Localize Background Images
 */
function sosimple_enqueue_background_images() {
	// Enqueue scripts and styles if there are posts with background images.
	if ( $background_images = sosimple_get_background_images() ) :
		wp_enqueue_style( 'sosimple-background-images', get_template_directory_uri() . '/add-ons/background-images/css/style.css' );
		wp_enqueue_script( 'sosimple-background-images', get_template_directory_uri() . '/add-ons/background-images/js/script.js', array( 'jquery' ), sosimple_version_id(), true );
		
		// Localize background images for use in JS
		wp_localize_script( 'sosimple-background-images', 'sosimpleL10n', array( 
			'backgroundImages' => $background_images,
		) );
	endif;
}
add_action( 'wp_enqueue_scripts', 'sosimple_enqueue_background_images' );


/**
 * Create a list of posts with featured images.
 *
 * @return array
 */
function sosimple_get_background_images() {
	$background_images = array();

	// Add intro page background image to background images array if available
	if ( is_home() && ! is_paged() && ( $intro_page = get_theme_mod( 'intro_page' ) ) ) :
		$background_images = sosimple_build_background_images_list( $intro_page, $background_images );
	endif;

	// Loop through posts and create a list of featured images
	while ( have_posts() ) : the_post();
		$background_images = sosimple_build_background_images_list( get_the_ID(), $background_images );
	endwhile;

	return $background_images;
}


/**
 * Add featured image to background images array if available
 */
function sosimple_build_background_images_list( $post_id, $background_images ) {
	if ( $thumbnail_id = get_post_thumbnail_id( $post_id ) ) {
		// Show large image sizes on single pages
		$size = ( is_home() || is_archive() ) ? 'post-thumbnail' : 'large';

		// Get post thumbnail source.
		$attachment_image_src = wp_get_attachment_image_src( $thumbnail_id, $size );
		
		// Add post ID and image to an array of images
		$background_images[$post_id] = esc_url( $attachment_image_src[0] );
	}

	return $background_images;
}


/**
 * Add post class if a featured image is set
 */
function sosimple_add_background_images_post_class( $classes, $class, $post_id ) {
	if ( '' != get_post_thumbnail_id( $post_id ) ) {
		$classes[] = 'has-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'sosimple_add_background_images_post_class', 10, 3 );