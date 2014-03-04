<?php
/*  
Plugin Name: DJ Gigs
Plugin URI: http://wearebio.com/djgigs/
Description: Full-featured dj gig management plugin for WordPress
Version: 1.0
Author: Joshua Michaels/BioDesign
Author URI: http://wearebio.com/
License: GPLv2
*/

/*  Copyright 2014  BioDesign  (email : info@wearebio.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// run install function
register_activation_hook( __FILE__, 'djgigs_install' );


function djgigs_install () {

	// check WP compatibility
	global $wp_version;

	if ( version_compare($wp_version, '3.5', '<' ) ) {
		wp_die( 'DJ Gig requires WordPress version 3.5 or higher. Please upgrade now.');
	}

	// TODO: add install functions 
}

register_deactivation_hook( __FILE__, 'djgigs_deactivate' );

function djgigs_deactivate() {
	// TODO: deactivation here
}

add_action( 'init', 'djgigs_init' );

function djgigs_init() {

	// make plugin available for translation
	load_plugin_textdomain( 'djgigs', false, plugin_basename( dirname(__FILE__) . '/localization' ) );

	// TODO: add plugin init functions

}



// Useful stuff for later: 

// Local directory paths:
// 
// get full local directory path
// echo plugin_dir_path( __FILE__ );

// // get 'script.js' in /js directory
// echo plugin_dir_path( __FILE__ . 'js/script.js' );

// // full file URLs
// echo '<img src="' . plugins_url( 'images/icon.png', __FILE__ ) . '">';

// ** PLUGIN OPTIONS ARRAY ** 
// $djgigs_options_arr = array(

// // TODO: add plugin options
// 	'option1'	=>	'value1',
// 	'option1'	=>	'value1',
// 	'option1'	=>	'value1',
// 	'option1'	=>	'value1',
// 	'option1'	=>	'value1',
// 	'option1'	=>	'value1',

// );

// update_option( 'djgigs_plugin_options', $djgigs_options_arr );


// create custom plugin settings menu
add_action( 'admin_menu', 'djgigs_admin_menu');

// add settings menu page
function djgigs_admin_menu() {

	global $gpo, $wp_version;

	$add = __("Add gig", "djgigs");
	$gigs = __("Gigs", "djgigs");
	$parties = __("Parties", "djgigs");
	$artists = __("Artists", "djgigs");
	$venues = __("Venues", "djgigs");
	$tours = __("Tours", "djgigs");
	$settings = __("Settings", "djgigs");
	$export = __("Import/Export", "djgigs");

	$icon = ($wp_version >= 3.8) ? 'dashicons-calendar' : plugins_url('images/djgigs-icon-16.png', __FILE__);

	add_menu_page( 'DJ Gigs', 'DJ Gigs', 'manage_options', 'djgigs_main_menu', 'djgigs_main_page', $icon);

	// add_menu_page("DJ Gigs - $add", "DJ Gigs", $gpo['user_level'], __FILE__, "djgigs_add", $icon);
	// 
	// 
	add_submenu_page( 'djgigs_main_menu', 'DJ Gigs - Settings', 'Settings', 'manage_options', 'djgigs_settings', 'djgigs_settings_page' );

	// By setting the unique identifier of the submenu page to be __FILE__,
	// we let it be the first page to load when the top-level menu item is clicked
	// add_submenu_page(__FILE__, "DJ Gigs - $add", $add, $gpo['user_level'], __FILE__, "djgigs_add");
	// add_submenu_page(__FILE__, "DJ Gigs - $gigs", $gigs, $gpo['user_level'], "djgigs-gigs", "djgigs_admin_gigs");
	// add_submenu_page(__FILE__, "DJ Gigs - $parties", $parties, $gpo['user_level'], "djgigs-parties", "djgigs_parties");
	// add_submenu_page(__FILE__, "DJ Gigs - $artists", $artists, $gpo['user_level'], "djgigs-artists", "djgigs_artists");
	// add_submenu_page(__FILE__, "DJ Gigs - $venues", $venues, $gpo['user_level'], "djgigs-venues", "djgigs_venues");
	// add_submenu_page(__FILE__, "DJ Gigs - $tours", $tours, $gpo['user_level'], "djgigs-tours", "djgigs_tours");
	// add_submenu_page(__FILE__, "DJ Gigs - $settings", $settings, 'manage_options', "djgigs-settings", "djgigs_settings");
	// add_submenu_page(__FILE__, "DJ Gigs - $export", $export, $gpo['user_level'], "djgigs-import-export", "djgigs_import_export");

	add_action( 'admin_init', 'djgigs_register_settings' );

}


function djgigs_register_settings() {

	// register our settings
	register_setting( 'djgigs-settings-group', 'djgigs_options', 'djgigs_sanitize_options' );
}

function djgigs_settings_page() { ?>
	
	<div class="wrap">

	<h2>DJ Gigs Options</h2>

	<form method="post" action="options.php">

		<?php settings_fields( 'djgigs-settings-group' ); ?>
		<?php $djgigs_options = get_option( 'djgigs_options' ); ?>

		<table class="form-table">
		<tr
		





	</form>












<?php }




























// function djgigs_admin_head()	{
// 	wp_enqueue_script('jquery');
// 	wp_enqueue_script('jquery-ui-sortable');
// 	wp_enqueue_script('gigpress-admin-js', plugins_url('scripts/gigpress-admin.js', __FILE__), 'jquery');
// 	wp_enqueue_style('gigpress-admin-css', plugins_url('css/gigpress-admin.css', __FILE__));
// }


function enable_custom_menu_order($flag) {
	return TRUE;
}

function custom_menu_order($menu_order) {
	
	// Add a new separator to the menu array
	global $menu;
	$menu[] = array('', 'read', 'separator-gp', '', 'wp-menu-separator');
	
	// Remove the current instance of GigPress
	$current_position = array_search('gigpress/gigpress.php', $menu_order);
	unset($menu_order[$current_position]);
	
	// Create a new array to hold the menu order
	$new_menu_order = array();
	
	// Replicate the existing order,
	// inserting GigPress and separator where desired
	foreach($menu_order as $menu_item) {
		$new_menu_order[] = $menu_item;
		if($menu_item == 'edit-comments.php')
		{
			$new_menu_order[] = 'separator-gp';
			$new_menu_order[] = 'djgigs/djgigs.php';		
		}
	}

	return $new_menu_order;
}

function gigpress_template($path) {

	// Look for our template in the following locations:
	// 1) Child theme directory
	// 2) Parent theme directory
	// 3) wp-content directory
	// 4) Default template directory
	
	if(file_exists(get_stylesheet_directory() . '/djgigs-templates/' . $path . '.php')) {
		$load = get_stylesheet_directory() . '/djgigs-templates/' . $path . '.php';
	} elseif(file_exists(get_template_directory() . '/djgigs-templates/' . $path . '.php')) {
		$load = get_template_directory() . '/djgigs-templates/' . $path . '.php';
	} elseif(file_exists(WP_CONTENT_DIR . '/djgigs-templates/' . $path . '.php')) {
		$load = WP_CONTENT_DIR . '/djgigs-templates/' . $path . '.php';
	} else {
		$load = WP_PLUGIN_DIR . '/djgigs/templates/'  . $path . '.php';
	}
	return $load;
}





























?>