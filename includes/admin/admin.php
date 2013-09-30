<?php
/**
 * Admin functions and definitions
 *
 * @package sosimple
 */


/**
 * Include So Simple admin tweaks
 */
if ( ! get_theme_mod( 'disable_admin_teaks' ) ) {
	require( get_template_directory() . '/includes/admin/tweaks.php' );
}

/**
 * Include custom meta boxes
 */
require( get_template_directory() . '/includes/admin/metabox.php' );


/**
 * Update Metabox Post Meta
 */
function sosimple_update_post_meta_field( $fields, $post_id ) {
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) && ! empty( $_POST[ $field ] ) ) {
			if ( is_string( $_POST[$field] ) ) {
				$new = esc_attr( $_POST[$field] );
			} elseif ( is_array( $_POST[$field] ) ) {
				$new = implode( ',', $_POST[$field] );
			} else {
				$new = $_POST[ $field ];
			}

			$new = apply_filters( 'sosimple_metabox_save_' . $field, $new );
			
			update_post_meta( $post_id, $field, $new );
		} else {
			delete_post_meta( $post_id, $field );
		}
	}
}


/**
 * Custom checked function, allows for an array to be passed.
 */
function sosimple_checked( $haystack, $current, $echo = true ) {
	if ( is_array( $haystack ) && in_array( $current, $haystack ) ) {
		$current = $haystack = 1;
	}

	checked( $haystack, $current, $echo );
}
