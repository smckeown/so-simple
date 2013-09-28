<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sosimple_setup_background_images() {
	// Add support for post thumbnails and register custom image sizes.
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'sosimple_setup_background_images' );


/**
 * Localize Background Images
 */
function sosimple_enqueue_background_images() {
	$background_images = array();

	// Loop through
	while ( have_posts() ) : the_post();
		if ( $thumbnail_id = get_post_thumbnail_id() ) {
			// Show large image sizes on single pages
			$size = ( is_home() || is_archive() ) ? 'post-thumbnail' : 'large';

			// Get post thumbnail source.
			$attachment_image_src = wp_get_attachment_image_src( $thumbnail_id, $size );
			
			// Add post ID and image to an array of images
			$background_images[get_the_ID()] = esc_url( $attachment_image_src[0] );
		}
	endwhile;

	// Enqueue scripts and styles if there are posts with background images.
	if ( $background_images ) :
		wp_enqueue_style( 'sosimple-background-images', get_template_directory_uri() . '/add-ons/background-images/css/style.css' );
		wp_enqueue_script( 'sosimple-background-images', get_template_directory_uri() . '/add-ons/background-images/js/script.js', array( 'jquery' ), '1.2.0', true );
		
		// Localize background images for use in JS
		wp_localize_script( 'sosimple-background-images', 'sosimpleL10n', array( 
			'background_images' => $background_images,
		) );
	endif;
}
add_action( 'wp_enqueue_scripts', 'sosimple_enqueue_background_images' );


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