<?php
/*
* This file explains in more detail the google map field in list view.
*
* We have two map fields: 'venue' google map and event ('djgig') google map. 
* The venue google map is set within each venue post and the event google map
* is set within the 'djgig' posts. If we use the Venue as location within our 
* djgig post, we need to grab the venue google map. Otherwise, grab the event 
* google map.
* 
* The list template uses a custom WP_Query to filter through 'djgig' posts
* so we need some extra shizzle to grab the map from the 'venue' custom 
* post type within our loop. It makes perfect sense once you get it!
* 
* 
*/


?>

<td class="djgigs-google-map" colspan="6">
	
	<?php $posts = get_field('djgigs_venue'); // Grab our venue field within djgig post type
 
		if( $posts ): // If we are using venue for the location
    
    		foreach( $posts as $post): // Split out venue(s) from venue post array (there will only always be 1 item in this array)

       			setup_postdata($post); // Format post data so we can display the elements just like normal posts

       			$vmap = get_field('djgigs_venue_google_map', $post->ID); // Now we can grab individual map field within the venue post ?>

					<?php // Show the venue google map with marker ?>
       				<div class="acf-map">
						<div class="marker" data-lat="<?php echo $vmap['lat']; ?>" data-lng="<?php echo $vmap['lng']; ?>"></div>
					</div>

    		<?php endforeach; // We've only had to loop once so we're done

    		wp_reset_postdata(); // Reset post data so main page loop will work
		
		else : // If there's no venue map, use the event google map
    
    	$location = get_field('djgigs_google_map');

			if( !empty($location) ): // Only display if there is a "there" there. ?>

				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></di>
				</div>

			<?php endif; // End our if event google map statement
		
		endif; // and we're done. That wasn't so bad, was it? ?>
	
</td>