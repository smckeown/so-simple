<?php
/**
 * Add Custom Peralink meta box field to Post Options meta box.
 */
function sosimple_custom_permalink_mb_field( $post_id ) { 
	$field_name = 'custom_permalink';
	$value = get_post_meta( $post_id, $field_name, true ); ?>
	<p>
		<label for="<?php echo esc_attr( $field_name ) ?>"><strong><?php _e( 'Custom Permalink', 'sosimple' ); ?></strong></label><br />
		<input name="<?php echo esc_attr( $field_name ) ?>" id="<?php echo esc_attr( $field_name ) ?>" class="widefat" type="text" value="<?php echo esc_attr( $value ); ?>" placeholder="http://" />
	</p>
	
<?php }
add_action( 'sosimple_post_options_mb_fields', 'sosimple_custom_permalink_mb_field', 10 );


/**
 * Add Custom Peralink meta box field to Post Options meta box save routine.
 */
function sosimple_custom_permalink_mb_save( $fields ) {
	$fields[] = 'custom_permalink';
	return $fields;
}
add_filter( 'sosimple_post_options_mb_save', 'sosimple_custom_permalink_mb_save' );


/**
 * Set custom permalink value
 */
function sosimple_custom_permalink( $permalink ) {
	if ( $custom_permalink = get_post_meta( get_the_ID(), 'custom_permalink', true ) ) {
		$permalink = $custom_permalink
	}

	return $permalink;
}
add_filter( 'sosimple_content_permalink', 'sosimple_custom_permalink' );