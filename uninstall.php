<?php
// If uninstall/delete not called from WordPress then exit
if ( !defined ( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

// Delete option from options table
delete_option( 'djgigs_options_arr' );

// Delete any other options, custom tables/data, files 

?>