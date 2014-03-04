<?php

require_once ( dirname(__FILE__).'/class.settings-api.php');

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WeDevs_Settings_API_Test' ) ):
class WeDevs_Settings_API_Test {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'DJ Gigs', 'DJ Gigs', 'manage_options', 'djgigs_options', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'djgigs_basic_settings',
                'title' => __( 'DJ Gigs Options', 'wedevs' )
            )
        );
        return $sections;
    }

     function flush_settings() {

    	if( isset( $_REQUEST['djgigs_rewrite_slug'] ) )
    	flush_rewrite_rules();
	}

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'djgigs_basic_settings' => array(
            	array(
                    'name' => 'djgigs_google_map_width_select',
                    'label' => __( 'Select pixels or percentage', 'wedevs' ),
                    'desc' => __( 'Use this to select the Google Map width base unit. Choose percentage for responsive widths.', 'wedevs' ),
                    'type' => 'select',
                    'default' => 'percentage',
                    'options' => array(
                        'percentage' => 'percentage',
                        'pixels' => 'pixels'
                    )
                ),
                array(
                    'name' => 'djgigs_google_map_width',
                    'label' => __( 'Google Map width', 'wedevs' ),
                    'desc' => __( 'Enter default Google Map width in pixels or percentage.', 'wedevs' ),
                    'type' => 'text',
                    'default' => '100%',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'djgigs_google_map_height_select',
                    'label' => __( 'Select pixels or percentage', 'wedevs' ),
                    'desc' => __( 'Use this to select the Google Map height base unit. Choose percentage for responsive height.', 'wedevs' ),
                    'type' => 'select',
                    'default' => 'percentage',
                    'options' => array(
                        'percentage' => 'percentage',
                        'pixels' => 'pixels'
                    )
                ),
                array(
                    'name' => 'djgigs_google_map_height',
                    'label' => __( 'Google Map height', 'wedevs' ),
                    'desc' => __( 'Enter default Google Map height in pixels or percentage.', 'wedevs' ),
                    'type' => 'text',
                    'default' => '400px',
                    'sanitize_callback' => 'intval'
                ),
                 array(
                    'name' => 'djgigs_rewrite_slug',
                    'label' => __( 'Permalink Slug', 'wedevs' ),
                    'desc' => __( 'Enter a custom permalink slug. The default is \'djgig\' but you could change it to \'gigs\' or \'events\'. ', 'wedevs' ),
                    'type' => 'text',
                    'default' => 'djgig',
                ),
                array(
                    'name' => 'djgigs_default_currency',
                    'label' => __( 'DJ Gigs Default Currency', 'wedevs' ),
                    'desc' => __( 'Select the default currency. Used for event ticket prices.', 'wedevs' ),
                    'type' => 'radio',
                    'default' => 'dollar',
                    'options' => array(
                        'dollar' => '$ (Dollar)',
                        'gbp' => '£ (British Pound)',
                        'euro' => '€ (Euro)'
                    )
                )
            )
            
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        settings_errors();

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

$settings = new WeDevs_Settings_API_Test();