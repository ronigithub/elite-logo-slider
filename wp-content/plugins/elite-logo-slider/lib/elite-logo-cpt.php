<?php
/**
 *
 * Register Elite Logo Slider Post type
 *
 */

if ( ! function_exists( 'els_registered_cpt' )) {
	function els_registered_cpt() {

		$labels = array(
	        'name'                  => _x( 'Elite Logos', 'josimuddinroni' ),
	        'singular_name'         => _x( 'Logo', 'josimuddinroni' ),
	        'menu_name'             => _x( 'Elite Logos', 'josimuddinroni' ),
	        'name_admin_bar'        => _x( 'Elite Logo', 'josimuddinroni' ),
	        'add_new'               => __( 'Add New Logo', 'elite-logo', 'josimuddinroni' ),
	        'add_new_item'          => __( 'Add New Logo', 'josimuddinroni' ),
	        'new_item'              => __( 'New Logo', 'josimuddinroni' ),
	        'edit_item'             => __( 'Edit Logo', 'josimuddinroni' ),
	        'view_item'             => __( 'View Logo', 'josimuddinroni' ),
	        'view_items'            => __( 'View Logos', 'josimuddinroni' ),
	        'all_items'             => __( 'All Logos', 'josimuddinroni' ),
	        'search_items'          => __( 'Search Logos', 'josimuddinroni' ),
	        'parent_item_colon'     => __( 'Parent Logos:', 'josimuddinroni' ),
	        'not_found'             => __( 'No logos found.', 'josimuddinroni' ),
	        'not_found_in_trash'    => __( 'No logos found in Trash.', 'josimuddinroni' )
	    );

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'elite-logo' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'			 => 'dashicons-screenoptions',
			'supports'           => array( 'title', 'thumbnail'),
		);

		register_post_type( 'elite-logo-slider', $args );
	}
}

add_action( 'init', 'els_registered_cpt' ); 

/**
 * Register Theme Features
 */
if ( ! function_exists( 'els_theme_support' ) ) {
	function els_theme_support() {

		// Add theme support for Featured Images
		add_theme_support( 'post-thumbnails', array( 'elite-logo-slider' ) );
		add_theme_support( 'post-thumbnails', array( 'post' ) ); // Add it for posts
		add_theme_support( 'post-thumbnails', array( 'page' ) ); // Add it for pages
		add_theme_support( 'post-thumbnails', array( 'product' ) ); // Add it for products
		add_theme_support( 'post-thumbnails');
		
		// Add Shortcode support in text widget
		add_filter('widget_text', 'do_shortcode'); 

	}

	add_action( 'after_setup_theme', 'els_theme_support' );
}

