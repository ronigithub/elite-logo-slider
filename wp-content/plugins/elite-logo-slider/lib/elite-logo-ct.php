<?php
/**
 *
 * Register Elite Logo Category
 *
 */
if ( ! function_exists( 'els_registered_cat' ) ) {
	function els_registered_cat() {

		$labels = array(
		'name'              => _x( 'Logo Categories', 'josimuddinroni' ),
		'singular_name'     => _x( 'Logo Category', 'josimuddinroni' ),
		'search_items'      => __( 'Search Logo Categories', 'josimuddinroni' ),
		'all_items'         => __( 'All Logo Category', 'josimuddinroni' ),
		'parent_item'       => __( 'Parent Logo  Category', 'josimuddinroni' ),
		'parent_item_colon' => __( 'Parent Logo  Category:', 'josimuddinroni' ),
		'edit_item'         => __( 'Edit Logo Category', 'josimuddinroni' ),
		'update_item'       => __( 'Update Logo Category', 'josimuddinroni' ),
		'add_new_item'      => __( 'Add New Logo Category', 'josimuddinroni' ),
		'new_item_name'     => __( 'New Logo Category Name', 'josimuddinroni' ),
		'menu_name'         => __( 'Logo Category', 'josimuddinroni' ),
		'not_found'         => __( 'No logo categories found.', 'josimuddinroni' ),
		'no_terms'         => __( 'No logo categories.', 'josimuddinroni' ),
		);

		$args = array(
			'labels' 			 => $labels,
			'public'			 => 'true',
			'publicly_queryable' => 'true',
			'hierarchical' 		 => 'true',
			'show_ui' 			 => 'false',
			'show_in_menu' 		 => 'true',
			'show_admin_column'  => 'false',
			'rewrite' 			 => array( 'slug' => 'logo-categories'),
		);
		
		register_taxonomy( 'elite-logo-category', 'elite-logo-slider', $args );
	}
}
add_action( 'init', 'els_registered_cat' );