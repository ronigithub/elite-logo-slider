<?php
/**
 * Plugin Name:	Elite Logo Slider
 * Description:	Best Responsive Logo slider with shortcode ready. You can display partners, clients or sponsors Logo on Wordpress site. Display anywhere at your site using shortcode like [elite-logo-slider]. You can easily integrate in themes.
 * Version:		1.0
 * Author:		Md. Josim Uddin Roni
 * Text Domain: josimuddinroni
 * License: 	GPL-2.0+
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WPLS') ){
	define( 'WPLS', dirname( __FILE__ ) );
}

//---------  Elite CPT  -------------------
require_once WPLS . "/lib/elite-logo-cpt.php";
//---------  Elite CT  -------------------
require_once WPLS . "/lib/elite-logo-ct.php";
//---------  Metaboxes  -------------------
require_once WPLS . "/lib/elite-logo-metabox.php";
//---------  Screen Columns  -------------------
require_once WPLS . "/lib/elite-logo-columns.php";

//---------  Logo Shortcode  -------------------
require_once WPLS . "/public/elite-logo-display.php";

//---------  Logo Settings  -------------------

require_once WPLS . "/lib/settings/class.els-settings-api.php";
require_once WPLS . "/lib/settings/elite-logo-settings.php";
new ELS_Settings;

/**
 * Activation Hook
 * Register plugin activation hook.
 */
register_activation_hook( __FILE__, 'els_activate' );

/**
 * Plugin Deactivation Function
 * Delete  plugin options
 */
register_deactivation_hook( __FILE__, 'els_deactivate' );

/**
 * Plugin Activation Function
 * Does the initial setup, sets the default values for the plugin options
 */
 if( ! function_exists( 'els_activate' ) ){
	function els_activate() {		
		els_registered_cpt();
		els_registered_cat();

		flush_rewrite_rules();
	}
}

/**
 * Plugin Deactivation Function
 * Delete  plugin options
 */
function els_deactivate() {
	// clear the permalinks to remove our post type's rules
    flush_rewrite_rules();
}

function els_wp_enqueue_scripts() 	{
	if( ! is_admin() ){

	   /* ###################################
		    		  CSS FILES   
		  ################################### */

		wp_enqueue_style('css-bxslider', plugins_url('css/jquery.bxslider.css', __FILE__),'','4.2.12', false);
		wp_enqueue_style('els-main-style', plugins_url('css/elite.css', __FILE__),'','1.0', false);				
	   
	   /* ###################################
		    		  JS FILES   
		  ################################### */

		wp_enqueue_script('jquery');

		wp_enqueue_script('js-bxslider', plugins_url('js/jquery.bxslider.min.js', __FILE__),array('jquery'),'4.2.12', true);

		wp_enqueue_script('easing-jq', plugins_url('js/jquery.easing.1.3.js', __FILE__),array('jquery'),'1.3', true);
		
		wp_enqueue_script('js-elite', plugins_url('js/elite.js', __FILE__),array('jquery'),'1.0', true);
	}
}

add_action( 'wp_enqueue_scripts', 'els_wp_enqueue_scripts');

/**
 * Admin Enqueue scripts
 */
function els_admin_enqueue_scripts() {
	global $pagenow, $typenow;
	$media = 'all';
	if( $pagenow == 'edit.php' && $typenow == 'elite-logo-slider'){
		// -------- Admin CSS Files -----

		wp_enqueue_style('els-admin-style', plugins_url('css/elite-admin.css', __FILE__), '', '1.0', false);
		// --------- Admin JS Files------
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('els-main-js', plugins_url('js/elite-js-admin.js', __FILE__), array('jquery'), '1.0', true);
		// wp_enqueue_script('els-angular', plugins_url('js/angular.min.js', __FILE__), '', '1.4.8', true);

	}
}

add_action( 'admin_enqueue_scripts', 'els_admin_enqueue_scripts');

