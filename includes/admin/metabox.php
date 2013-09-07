<?php

/**
 * Load metabox files
 */
require( get_template_directory() . '/includes/admin/metabox/post-options.php' );


/**
 * Add scripts and styles
 */
function so_simple_meta_box_scripts( $hook ) {
	wp_enqueue_style( 'debut-admin-style', get_template_directory_uri() . '/assets/styles/admin.css', array(), debut_version_id() );
	wp_enqueue_script( 'debut-admin-script', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), debut_version_id(), true );
}
//add_action( 'admin_enqueue_scripts', 'so_simple_meta_box_scripts' );


/**
 * Add meta boxes
 */
function so_simple_add_meta_boxes( $post_type ) {
	add_meta_box( 'so_simple_featured_video', __( 'Post Options', 'so-simple-i18n' ), 'so_simple_render_post_options_mb', 'post', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'so_simple_add_meta_boxes' );