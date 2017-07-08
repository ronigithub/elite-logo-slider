<?php
/**
 * Display additional column
 */
add_filter( 'manage_edit-elite-logo-slider_columns', 'els_screen_columns' );

function els_screen_columns( $columns ) {
	unset(
		$columns['title'] ,
		$columns['author'] ,
		$columns['taxonomy-elite-logo-category'],
		$columns['date']
	);

	$columns['title'] 			  			 = __( 'Title' );
	$columns['col_fea_logo']				 = __( 'Client\'s Logo' );
	$columns['taxonomy-elite-logo-category'] = __( 'Logo Category' );
	$columns['col_logo_url']      			 = __( 'Logo URL' );
	$columns['author']			  			 = __( 'Author' );
	$columns['date']		 	  			 = __( 'Date' );
	
	return $columns;
}

// Get Featured image
function get_featured_logo( $post_id ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $post_thumbnail_id ) {
		$post_thumbnail_image = wp_get_attachment_image_src( $post_thumbnail_id , array(45,45),  true);
		return $post_thumbnail_image[0]; 
	}

}

// Featured image into screen
add_action( 'manage_posts_custom_column', 'els_columns_content', 10, 2 );

function els_columns_content( $columns, $post_id ) {
	if ($columns == 'col_fea_logo') {
		$featured_logo = get_featured_logo( $post_id );
	    if ($featured_logo) {
	        echo '<img src="' . $featured_logo . '" />';
	    }
	}

}

// Logo url link on screen
add_action( 'manage_posts_custom_column', 'els_populate_columns' );

function els_populate_columns( $columns ) {

    if ( 'col_logo_url' == $columns ) {
        $client_url = get_post_meta( get_the_ID(), 'els_site_url', true );
        echo $client_url;
    }
}


// All Columns as Sortable
add_filter( 'manage_edit-elite-logo-slider_sortable_columns', 'els_sort' );

function els_sort( $columns ) {
    $columns['col_fea_logo'] = 'col_fea_logo';
    $columns['col_logo_url'] = 'col_logo_url';
    $columns['author'] 		 = 'author';
    $columns['taxonomy-elite-logo-category'] = 'taxonomy-elite-logo-category';
 
    return $columns;
}