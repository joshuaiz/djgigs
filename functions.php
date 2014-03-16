<?php



/**
 * Retrieve the event start date.
 *
 * @since 1.0.0
 * @return string 
 */
function djgigs_start_date() {

	$date = get_field('djgigs_event_start_date');
	//split the field at the first space and store the date in $datepart and the time in $timepart
	list ($startdate, $starttime) = explode(' ', $date, 2);

	return $startdate;

}

/**
 * Retrieve the event start time.
 *
 * @since 1.0.0
 * @return string 
 */
function djgigs_start_time() {

	$date = get_field('djgigs_event_start_date');
	//split the field at the first space and store the date in $datepart and the time in $timepart
	list ($startdate, $starttime) = explode(' ', $date, 2);

	return $starttime;

}

/**
 * Retrieve the event end date.
 *
 * @since 1.0.0
 * @return string 
 */
function djgigs_end_date() {

	$date = get_field('djgigs_event_end_date');
	//split the field at the first space and store the date in $datepart and the time in $timepart
	list ($enddate, $endtime) = explode(' ', $date, 2);

	return $enddate;

}

/**
 * Retrieve the event end time.
 *
 * @since 1.0.0
 * @return string 
 */

function djgigs_end_time() {

	$date = get_field('djgigs_event_end_date');
	//split the field at the first space and store the date in $datepart and the time in $timepart
	list ($enddate, $endtime) = explode(' ', $date, 2);

	return $endtime;

}


function djgigs_google_map_size() {

	$wunit = get_option('djgigs_google_map_width_select');
	$wvalue = get_option('djgigs_google_map_width');
	$gmwidth = $wvalue.$wunit;

	$hunit = get_option('djgigs_google_map_width_select');
	$hvalue = get_option('djgigs_google_map_width');
	$gmheight = $hvalue.$hunit;

	return array($gmwidth, $gmheight);
}


// function djgigs_rewrite_rule() {

// 	global $wp_post_types;
//     $rewrite = &$wp_post_types['djgig']->rewrite;
//     $slug = get_option( 'djgigs_rewrite_slug' );
//     $rewrite['slug'] = $slug;

// }
// add_action( 'init', 'djgigs_rewrite_rule', 999 );
// 

function add_custom_rewrite_rule() {

    // First, try to load up the rewrite rules. We do this just in case
    // the default permalink structure is being used.
    if( ($current_rules = get_option('rewrite_rules')) ) {

    	$slug = get_option( 'djgigs_rewrite_slug' );

        // Next, iterate through each custom rule adding a new rule
        // that replaces 'movies' with 'films' and give it a higher
        // priority than the existing rule.
        foreach($current_rules as $key => $val) {
            
                add_rewrite_rule(str_ireplace($val, $slug, $key), $val, 'top');   
            
        } // end foreach

    } // end if/else

    // ...and we flush the rules
    flush_rewrite_rules();

} // end add_custom_rewrite_rule
add_action('init', 'add_custom_rewrite_rule');





function djgigs_calendar () {

}



function djgigs_widget_update_save_post()
{
	if ( 'djgig' == get_post_type() ) {

		add_action( 'save_post', 'flush_widget_cache' );
		add_action( 'deleted_post', 'flush_widget_cache' );
		add_action( 'switch_theme', 'flush_widget_cache' );

	}
   
}



// function djgigs_image_width() {

// 	$w = get_option( 'djgigs_default_image_size' );
// 	$width = get_option( $w . '_size_w' );
// 	return $width;

// }

// function djgigs_image_height() {

// 	$h = get_option( 'djgigs_default_image_size' );
// 	$height = get_option( $h . '_size_h' );
// 	return $height;

// }
// 

// function djgigs_image_size() {

// 	$w = get_option( 'djgigs_default_image_size' );
// 	$width = get_option( $w . '_size_w' );

// 	$h = get_option( 'djgigs_default_image_size' );
// 	$height = get_option( $h . '_size_h' );

// 	return array($width, $height);

// }



// function djgigs_image_size() {

// 	global $_wp_additional_image_sizes;

// 	foreach (get_intermediate_image_sizes() as $s) {
// 	if (isset($_wp_additional_image_sizes[$s])) {
// 		$width = intval($_wp_additional_image_sizes[$s]['width']);
// 		$height = intval($_wp_additional_image_sizes[$s]['height']);
// 	} else {
// 		$width = get_option($s.'_size_w');
// 		$height = get_option($s.'_size_h');
// 	}
// 	}

// 	return array($width, $height);

// }