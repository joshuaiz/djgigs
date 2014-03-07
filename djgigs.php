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

/*  Copyright 2014  Joshua Michaels/BioDesign  (email : info@wearebio.com)

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

// Define constants. Add the trailing slash so we can just use the file name. Sweetness.
define( 'DJGIGS', plugin_dir_url( __FILE__ ) );
define( 'DJGIGS_JS', plugin_dir_url( __FILE__ ) . 'js/' );
define( 'DJGIGS_CSS', plugin_dir_url( __FILE__ ) . 'css/' );
define( 'DJGIGS_ADMIN', plugin_dir_url( __FILE__ ) . 'admin/' );
define( 'DJGIGS_INCLUDES', plugin_dir_url( __FILE__ ) . 'includes/' );
define( 'DJGIGS_TEMPLATES', plugin_dir_url( __FILE__ ) . 'templates/' );
define( 'DJGIGS_FIELDS', plugin_dir_url( __FILE__ ) . 'fields/' );
define( 'DJGIGS_LANG', plugin_dir_url( __FILE__ ) . 'lang/' );

$plugin_url = plugin_dir_url( __FILE__ ); // alternative usage

register_activation_hook( __FILE__, 'djgigs_install' );

function djgigs_install() {
    
    global $wp_version;

	if ( version_compare($wp_version, '3.5', '<' ) ) {
		wp_die( 'DJ Gigs requires WordPress version 3.5 or higher. Please upgrade now.');
	}
    
}


register_deactivation_hook( __FILE__, 'djgigs_deactivate' );

function djgigs_deactivate() {
	// TODO: deactivation here
}

// function djgigs_create_options() {

// 	add_option( 'djgigs_plugin_options', array(

//     // 'djgigs_google_map_width' => '100%',
//     // 'djgigs_google_map_height' => '100%',
//     // 'djgigs_default_image_size' => 'thumbnail',
//     'djgigs_currency_dollar' 	=> '$',
//     'djgigs_currency_gbp'		=> '£',
//     'djgigs_currency_euro'		=> '€',
//     )
//     );
// }


// add_action( 'admin_menu', 'djgigs_create_menu' );

// function djgigs_create_menu() { 

// 	add_options_page( 'DJ Gigs Settings', 'DJ Gigs Settings', 'manage_options', 'djgigs_options', 'djgigs_settings_page' );

// }


// Register DJ Gig Custom Post Type
function djgig_cpt() {

	$labels = array(
		'name'                => _x( 'DJ Gigs', 'Post Type General Name', 'djgigs' ),
		'singular_name'       => _x( 'DJ Gig', 'Post Type Singular Name', 'djgigs' ),
		'menu_name'           => __( 'DJ Gigs', 'djgigs' ),
		'parent_item_colon'   => __( 'Parent DJ Gig:', 'djgigs' ),
		'all_items'           => __( 'All DJ Gigs', 'djgigs' ),
		'view_item'           => __( 'View DJ Gig', 'djgigs' ),
		'add_new_item'        => __( 'Add New DJ Gig', 'djgigs' ),
		'add_new'             => __( 'Add New DJ Gig', 'djgigs' ),
		'edit_item'           => __( 'Edit DJ Gig', 'djgigs' ),
		'update_item'         => __( 'Update DJ gig', 'djgigs' ),
		'search_items'        => __( 'Search DJ Gigs', 'djgigs' ),
		'not_found'           => __( 'No DJ Gigs found', 'djgigs' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'djgigs' ),
	);
	$args = array(
		'label'               => __( 'djgig', 'djgigs' ),
		'description'         => __( 'Post Type Description', 'djgigs' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ),
		// 'register_meta_box_cb' => 'add_djgigs_metaboxes',
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5.111,
		'menu_icon'           => 'dashicons-calendar',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'djgig', $args );

}

// Hook into the 'init' action
add_action( 'init', 'djgig_cpt', 0 );

// Register DJ Gigs Venue Custom Post type
function djgig_venue_cpt() {

	$labels = array(
		'name'                => _x( 'Venues', 'Post Type General Name', 'djgigs' ),
		'singular_name'       => _x( 'Venue', 'Post Type Singular Name', 'djgigs' ),
		'menu_name'           => __( 'Venues', 'djgigs' ),
		'parent_item_colon'   => __( 'Parent Venue:', 'djgigs' ),
		'all_items'           => __( 'All Venues', 'djgigs' ),
		'view_item'           => __( 'View Venue', 'djgigs' ),
		'add_new_item'        => __( 'Add New Venue', 'djgigs' ),
		'add_new'             => __( 'Add New Venue', 'djgigs' ),
		'edit_item'           => __( 'Edit Venue', 'djgigs' ),
		'update_item'         => __( 'Update Venue', 'djgigs' ),
		'search_items'        => __( 'Search Venues', 'djgigs' ),
		'not_found'           => __( 'No Venues found', 'djgigs' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'djgigs' ),
	);
	$args = array(
		'label'               => __( 'djgig_venue', 'djgigs' ),
		'description'         => __( 'DJ Gigs Venues', 'djgigs' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ),
		// 'register_meta_box_cb' => 'add_djgigs_metaboxes',
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5.222,
		'menu_icon'           => 'dashicons-location',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite'			  => array('slug' => 'venue'),
	);
	register_post_type( 'djgig_venue', $args );

}

// Hook into the 'init' action
add_action( 'init', 'djgig_venue_cpt', 0 );

// Register DJ Gigs Artist Custom Post Type
function djgig_artist_cpt() {

	$labels = array(
		'name'                => _x( 'Artists', 'Post Type General Name', 'djgigs' ),
		'singular_name'       => _x( 'Artist', 'Post Type Singular Name', 'djgigs' ),
		'menu_name'           => __( 'Artists', 'djgigs' ),
		'parent_item_colon'   => __( 'Parent Artist:', 'djgigs' ),
		'all_items'           => __( 'All Artists', 'djgigs' ),
		'view_item'           => __( 'View Artist', 'djgigs' ),
		'add_new_item'        => __( 'Add New Artist', 'djgigs' ),
		'add_new'             => __( 'Add New Artist', 'djgigs' ),
		'edit_item'           => __( 'Edit Artist', 'djgigs' ),
		'update_item'         => __( 'Update Artist', 'djgigs' ),
		'search_items'        => __( 'Search Artists', 'djgigs' ),
		'not_found'           => __( 'No Artists found', 'djgigs' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'djgigs' ),
	);
	$args = array(
		'label'               => __( 'djgig_artist', 'djgigs' ),
		'description'         => __( 'DJ Gigs Artists', 'djgigs' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ),
		// 'register_meta_box_cb' => 'add_djgigs_metaboxes',
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5.333,
		'menu_icon'           => 'dashicons-format-audio',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite'			  => array('slug' => 'artist'),
	);
	register_post_type( 'djgig_artist', $args );

}

// Hook into the 'init' action
add_action( 'init', 'djgig_artist_cpt', 0 );


// Load admin stylesheet
function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', DJGIGS_CSS . 'djgigs-admin.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

// TODO: combine all enqueues into one function and add conditionals
// Load plugin (front-end) styles 
function djgigs_enqueue_styles() {
        wp_register_style( 'djgigs-styles', DJGIGS_CSS . 'djgigs.css', false, '1.0.0' );
        wp_enqueue_style( 'djgigs-styles' );
}
add_action( 'wp_enqueue_scripts', 'djgigs_enqueue_styles' );


// Add script for table gigs layout
function djgigs_add_scripts() {

	wp_register_script( 'djgigs-js', DJGIGS_JS . 'djgigs.js', 'jquery', '', true );
	wp_register_script( 'djgigs-table', DJGIGS_JS . 'djgigs.table.js', 'jquery', '', true );	
	wp_register_script('google-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', '', '', true );
	wp_register_script( 'djgigs-map', DJGIGS_JS . 'djgigs.map.js', 'jquery', 'google-map', true );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'google-map');
	wp_enqueue_script( 'djgigs-js');
	wp_enqueue_script( 'djgigs-table');
	wp_enqueue_script( 'djgigs-map');

}
add_action( 'wp_enqueue_scripts', 'djgigs_add_scripts' );

// DJ Gigs includes
include( plugin_dir_path( __FILE__ ) . 'functions.php' );
include( plugin_dir_path( __FILE__ ) . '/includes/acf-date_time_picker/acf-date_time_picker.php');
include( plugin_dir_path( __FILE__ ) . '/includes/advanced-custom-fields/acf.php');
require_once ( plugin_dir_path( __FILE__ ) . '/includes/options.php') ;


// Register DJ Gigs shortcodes
add_shortcode( 'djgigs', 'djgigs_shortcode' );
add_shortcode( 'djgigs-list', 'djgigs_shortcode' );
add_shortcode( 'djgigs-calendar', 'djgigs_calendar_shortcode' );

function djgigs_shortcode() {

	ob_start();
  	include( plugin_dir_path( __FILE__ ) . '/templates/djgigs-list.php'); // grab template part 
 	return ob_get_clean();

}

function djgigs_calendar_shortcode() {

  	include( plugin_dir_path( __FILE__ ) . '/templates/djgigs-calendar.php'); // grab template part 

}

// Admin CPT columns
add_filter( 'manage_edit-djgig_columns', 'djgigs_edit_djgig_columns' ) ;

function djgigs_edit_djgig_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Event' ),
		'djgigs_event_image_1' => __( 'Image' ),
		'djgigs_artist' => __( 'Artist' ),
		'djgigs_event_start_date' => __( 'Event Date' ),
		'djgigs_venue' => __( 'City' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_djgig_posts_custom_column', 'djgigs_manage_djgig_columns', 10, 2 );

function djgigs_manage_djgig_columns( $column, $post_id ) {

	global $post;

	switch( $column ) {

		case 'djgigs_event_image_1' :

			$image = get_field( 'djgigs_event_image_1'); ?>
			<img src="<?php echo $image; ?>" width="48px" height="48px" />
			<?php break;

		case 'djgigs_artist' :
			$artists = get_field( 'djgigs_artist');
			if( $artists ): 
			foreach( $artists as $a ): // variable must NOT be called $post (IMPORTANT) ?>
	    	<a href="<?php echo get_permalink( $a->ID ); ?>"><?php echo get_the_title( $a->ID ); ?></a>
			<?php endforeach;
			endif;

			break;

		case 'djgigs_event_start_date' :
			/* Get the post meta. */
			$startdate = get_field('djgigs_event_start_date');
			echo date_i18n('l, F j, Y', $startdate);

			break;

		case 'djgigs_venue' :

			$posts = get_field('djgigs_venue');
			if( $posts ): ?>
    
    			<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        			<?php setup_postdata($post); ?>
        				<?php $city = get_field('djgigs_venue_city', $post->ID); ?>
       					<?php echo $city; ?>
    			<?php endforeach; ?>
    			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>

			<?php endif;

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter( 'manage_edit-djgig_sortable_columns', 'djgig_sortable_columns' );

function djgig_sortable_columns( $columns ) {

	$columns['djgigs_event_start_date'] = 'djgigs_event_start_date';

	return $columns;
}

add_action( 'load-edit.php', 'my_edit_djgig_load' );

function my_edit_djgig_load() {
	add_filter( 'request', 'my_sort_djgig' );
}


function my_sort_djgig( $vars ) {

	
	if ( isset( $vars['post_type'] ) && 'djgig' == $vars['post_type'] ) {

		if ( isset( $vars['orderby'] ) && 'djgigs_event_start_date' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'djgigs_event_start_date',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}

	return $vars;
}


add_filter( 'manage_edit-djgig_venue_columns', 'djgigs_edit_djgig_venue_columns' ) ;

function djgigs_edit_djgig_venue_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Venue' ),
		'djgigs_venue_address' => __( 'Address' ),
		'djgigs_venue_country' => __( 'Country' ),
	);

	return $columns;
}

add_action( 'manage_djgig_venue_posts_custom_column', 'djgigs_manage_djgig_venue_columns', 10, 2 );

function djgigs_manage_djgig_venue_columns( $column, $post_id ) {

global $post;

	switch( $column ) {

		case 'djgigs_venue_address' :

			echo the_field('djgigs_venue_address');?> <?php echo the_field('djgigs_venue_city'); ?>
			<?php if( get_field('djgigs_venue_state') ): ?>, <?php echo the_field('djgigs_venue_state'); ?>
			<?php endif; ?> <?php if( get_field('djgigs_venue_postcode') ): ?> <?php echo the_field('djgigs_venue_postcode'); ?>
			<?php endif; ?>
			
			<?php break;

		case 'djgigs_venue_country' :
			
			echo the_field('djgigs_venue_country');

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter( 'manage_edit-djgig_artist_columns', 'djgigs_edit_djgig_artist_columns' ) ;

function djgigs_edit_djgig_artist_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Artist' ),
		'djgigs_artist_image' => __( 'Image' ),
		'djgigs_artist_twitter' => __( 'Twitter' ),
		'djgigs_artist_link_1' => __( 'Website 1' ),
		'djgigs_artist_link_2' => __( 'Website 2' ),
	);

	return $columns;
}

add_action( 'manage_djgig_artist_posts_custom_column', 'djgigs_manage_djgig_artist_columns', 10, 2 );

function djgigs_manage_djgig_artist_columns( $column, $post_id ) {

global $post;

	switch( $column ) {

		case 'djgigs_artist_image' :

			$image = get_field( 'djgigs_artist_image'); ?>
			<img src="<?php echo $image; ?>" width="48px" height="48px" />
			<?php break;

		case 'djgigs_artist_twitter' :
			
			echo the_field('djgigs_artist_twitter');

			break;

		case 'djgigs_artist_link_1' : ?>
			
			<a href="<?php echo the_field('djgigs_artist_link_1'); ?>"><?php echo the_field('djgigs_artist_link_1'); ?></a>

			<?php break;

		case 'djgigs_artist_link_2' : ?>
			
			<a href="<?php echo the_field('djgigs_artist_link_2'); ?>"><?php echo the_field('djgigs_artist_link_2'); ?></a>

			<?php break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}


// Register widget
add_action( 'widgets_init', 'djgigs_register_widgets' );

function djgigs_register_widgets() {

	register_widget( 'DJGigs_Recent_Posts' );

}

/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class DJGigs_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'djgigs-widget', 'description' => __( "Recent DJ Gigs.") );
		parent::__construct('djgigs-recent-posts', __('DJ Gigs Widget'), $widget_ops);
		$this->alt_option_name = 'djgigs-widget';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('djgigs-recent-posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'DJ Gigs Widget' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
		if ( ! $number )
 			$number = 10;
 		$show_img = isset( $instance['show_img'] ) ? $instance['show_img'] : false;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$time = current_time( 'timestamp' ); // Get current unix timestamp
		
		// Set up custom query with meta_query to compare event start date with today's date
		$djargs = array (
		'post_type'              => 'djgig',
		'post_status'            => 'publish',
		'orderby' 				 => 'meta_value',
		'meta_key' 				 => 'djgigs_event_start_date', // order djgigs by date
		'meta_value'    	 	 => $time, 
		'meta_compare'      	 => '>=', // Compare today's datetime with our event datetime
		'order' 				 => 'ASC',
		'posts_per_page'         => $number,
		);

		$r = new WP_Query( $djargs );

		if ( $r->have_posts() ) : ?>

		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); // Start loop ?>
			<?php $startDate = get_field( 'djgigs_event_start_date' ); // Get event start date + time ?>
			<li>
			<?php if ( $show_img ) : ?>
				<img class="djgigs-event-image-img" src="<?php the_field('djgigs_event_image_1'); ?>" height="24px" width="24px"/>
			<?php endif; ?>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<?php $artist = get_field('djgigs_artist'); // Relationship field. Returns post object array
 					if( $artist ): ?>
    					<?php foreach( $artist as $a):  // Loop through artists (there will usually only be one) ?>
				<span><a href="<?php echo get_permalink( $a->ID ); ?>"><?php echo get_the_title( $a->ID ); ?></a></span>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php wp_reset_postdata(); // Reset loop so rest of page will work ?>
			<?php if ( $show_date ) : ?>
				<span class="djgigs-event-date"><?php echo date_i18n('Y/m/d', $startDate);  ?></span>
			<?php endif; ?>
			</li>
			
		
		<?php endwhile; // End loop ?>
		</ul>
		<?php echo $after_widget; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('djgigs-recent-posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_img'] = isset( $new_instance['show_img'] ) ? (bool) $new_instance['show_img'] : false;
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['djgigs-widget']) )
			delete_option('djgigs-widget');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('djgigs-recent-posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_img = isset( $instance['show_img'] ) ? (bool) $instance['show_img'] : false;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of events to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_img ); ?> id="<?php echo $this->get_field_id( 'show_img' ); ?>" name="<?php echo $this->get_field_name( 'show_img' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_img' ); ?>"><?php _e( 'Display event images?' ); ?></label></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display event date?' ); ?></label></p>

<?php
	}
}



?>