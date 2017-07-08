<?php

/**
 * Elite Logo Settings
 */
if ( !class_exists('ELS_Settings' ) ):
class ELS_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new ELS_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'els_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }


    // Elite logo menu
    function els_menu() {
    $parent_slug    =   "edit.php?post_type=elite-logo-slider";
    $page_title     =   "Logo Settings";
    $menu_title     =   "Logo Settings";
    $capability     =   "manage_options";
    $menu_slug      =   "logo-settings";
    $function       =   array( $this, "els_settings_page_callback");
    add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    }

    // For API
    function admin_menu() {
        add_options_page( 'Settings API', 'Settings API', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'els_titles',
                'title' => __( 'Title Settings', 'josimuddinroni' )
            )            
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(

            'els_titles' => array(

                // Logo Title
                array(
                    'name'    => 'title',
                    'label'   => __( 'Logo Title', 'josimuddinroni' ),
                    'desc'    => __( 'Display Logo with / without Title. Default: OFF', 'josimuddinroni' ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'ON',
                        'no'  => 'OFF'
                    ),
                ),

                // Logo Title Position
                array(
                    'name'    => 'title_position',
                    'label'   => __( 'Title Position', 'josimuddinroni' ),
                    'desc'    => __( 'Display title position on Logo.Default: Bottom Note: if set Top then trun ON title', 'josimuddinroni' ),
                    'type'    => 'select',
                    'default' => 'bottom',
                    'options' => array(
                        'top' => 'Top',
                        'bottom'  => 'Bottom'
                    ),
                ),
                             
            ), /* End of style settings */

        );

        return $settings_fields;
    }

    function els_settings_page_callback() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
