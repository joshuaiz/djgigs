<?php

add_filter( 'manage_edit-djgig_columns', 'my_edit_djgig_columns' ) ;

function my_edit_djgig_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Event' ),
		'djgigs_artist' => __( 'Artist' )
		'djgigs_event_start_date' => __( 'Event Date' ),
		'djgigs_venue_city' => __( 'City' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_djgig_posts_custom_column', 'my_manage_djgig_columns', 10, 2 );

function my_manage_djgig_columns( $column, $post_id ) {

	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'djgigs_artist' :

			/* Get the post meta. */
			$artist = get_post_meta( $post_id, 'djgigs_artist', true );

			/* If no duration is found, output a default message. */
			if ( empty( $artist ) )
				echo __( 'Unknown' );

			else

				echo __( $artist );

			break;

		/* If displaying the 'genre' column. */
		case 'djgigs_venue_city' :

			/* Get the post meta. */
			$city = get_post_meta( $post_id, 'djgigs_venue_city', true );

			if ( empty( $city ) )

				$city2 = get_post_meta( $post_id, 'djgigs_event_city', true );

				echo __( $city2 );

			else {
				
				echo __( $city );
			}

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}