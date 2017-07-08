<?php
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function els_meta_box() {

	add_meta_box( 
		'els_metabox_id',
		__("Client's URL", 'josimuddinroni'),
		'els_metabox_display_callback',
		'elite-logo-slider'
	);
}

add_action( 'add_meta_boxes', 'els_meta_box' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function els_metabox_display_callback( $post ) {

    wp_nonce_field( 'els_metabox_nonce_action', 'els_metabox_nonce' );
    $value = get_post_meta( $post->ID, 'els_site_url', true );
	echo '<label for="els_site_url">';
	echo __( "Add Site URL : ", "josimuddinroni" ); 		
	echo '</label>';
	echo '<input type="url" name="els_site_url" id="els_site_url" value="' .esc_attr( $value ) . '" style="width: 225px;" placeholder=" Enter url here..."/><br>';
	
	echo '<span style="padding-left: 96px;"><strong>Example:</strong> http://www.google.com</span>';


}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function els_save_meta_box( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!
    if ( ! isset( $_POST['els_metabox_nonce' ] ) ) {
    	return;
    }  	

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['els_metabox_nonce'], 'els_metabox_nonce_action' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'elite-logo-slider' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Make sure that it is set.
	if ( ! isset( $_POST['els_site_url'] ) ) {
		return;
	}

	// Sanitize user input.
	$url_data = sanitize_text_field( $_POST['els_site_url'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'els_site_url', $url_data );

}

add_action( 'save_post', 'els_save_meta_box' );

/**
 * Moving Featured image position below the title 
 */
function els_featured_image_metabox() {

	remove_meta_box( 'postimagediv', 'elite-logo-slider', 'side' );
	add_meta_box( 'postimagediv', __('Client\'s Logo'), 'post_thumbnail_meta_box', 'elite-logo-slider', 'normal', 'high' );
}

add_action( 'do_meta_boxes', 'els_featured_image_metabox' );