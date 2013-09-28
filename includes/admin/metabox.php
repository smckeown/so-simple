<?php
/**
 * Meta box setup and functions
 *
 * @package sosimple
 */


/**
 * Add meta boxes
 */
function sosimple_add_meta_boxes( $post_type ) {
	add_meta_box( 'sosimple_post_options', __( 'Post Options', 'sosimple' ), 'sosimple_render_post_options_mb', 'post', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'sosimple_add_meta_boxes' );


/**
 * Load metabox files
 */
require( get_template_directory() . '/includes/admin/metabox/post-options.php' );
