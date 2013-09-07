<?php
/**
 * Render Featured Video Meta Box
 */
function so_simple_render_post_options_mb( $post ) {
	// Nonce to verify intention later
	wp_nonce_field( 'so_simple_post_video_mb_save', 'so_simple_post_video_mb_nonce' );
	// Fields are attached with hooks
	do_action( 'so_simple_post_options_mb_fields', $post->ID );
}


/**
 * Permalink Override
 */
function so_simple_permalink_override_mb_field( $post_id ) { 
	$field_name = 'permalink_override';
	$value = get_post_meta( $post_id, $field_name, true ); ?>
	<p>
		<label for="<?php echo esc_attr( $field_name ) ?>"><strong><?php _e( 'Permalink Override', 'so-simple-i18n' ); ?></strong></label><br />
		<input name="<?php echo esc_attr( $field_name ) ?>" id="<?php echo esc_attr( $field_name ) ?>" class="widefat" type="text" value="<?php echo esc_attr( $value ); ?>" placeholder="http://" />
	</p>
	
<?php }
add_action( 'so_simple_post_options_mb_fields', 'so_simple_permalink_override_mb_field', 10 );


/**
 * Text Color
 */
function so_simple_text_color_mb_field( $post_id ) { 
	$field_name = 'text_color';
	$value = get_post_meta( $post_id, $field_name, true ); ?>
	<p>
		<label for="<?php echo esc_attr( $field_name ) ?>"><strong><?php _e( 'Text Color', 'so-simple-i18n' ); ?></strong></label><br />
		<select name="<?php echo esc_attr( $field_name ); ?>" id="<?php echo esc_attr( $field_name ); ?>" class="widefat">
			<?php 
			$options = array(
				'text-light' => __( 'Light Text', 'debut' ),
				'text-dark'  => __( 'Dark Text', 'debut' ),
			);
						
			foreach( $options as $option => $label ): 
				printf( '<option value="%1$s" %3$s>%2$s</option>',
					esc_attr( $option ),
					esc_html( $label ),
					selected( $value, $option, false )
				);
			endforeach;
			?>
		</select>	
	</p>
<?php }
add_action( 'so_simple_post_options_mb_fields', 'so_simple_text_color_mb_field', 10 );


/**
 * Save Video Metabox Values
 */
function so_simple_post_video_mb_save( $post_id ) {
	global $post;

	// verify nonce
	if ( ! isset( $_POST['so_simple_post_video_mb_nonce'] ) || ! wp_verify_nonce( $_POST['so_simple_post_video_mb_nonce'], 'so_simple_post_video_mb_save' ) ) 
		return;

	// check autosave
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) 
		return;

	// don't save if only a revision
	if ( wp_is_post_revision( $post_id ) ) 
		return;

	// check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;		
	
	// these are the default fields that get saved
	$fields = apply_filters( 'so_simple_post_video_mb_save', array(
		'permalink_override',
		'text_color',
	) );

	so_simple_update_post_meta_field( $fields, $post_id );

}
add_action( 'save_post', 'so_simple_post_video_mb_save' );

